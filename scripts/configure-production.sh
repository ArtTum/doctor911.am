#!/usr/bin/env bash

set -Eeuo pipefail
umask 027

SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="${DOCTOR911_PROJECT_ROOT:-$(cd -- "$SCRIPT_DIR/.." && pwd)}"
ENV_FILE="$PROJECT_ROOT/.env"
TIMESTAMP="$(date -u +%Y%m%dT%H%M%SZ)"
BACKUP_DIR="$PROJECT_ROOT/.deploy-backups/$TIMESTAMP"
PHP_BIN="${PHP_BIN:-$(command -v php || true)}"
WEB_USER="${WEB_USER:-www-data}"

log() {
    printf '[doctor911] %s\n' "$*"
}

die() {
    printf '[doctor911] ERROR: %s\n' "$*" >&2
    exit 1
}

[[ "${EUID:-$(id -u)}" -eq 0 ]] || die 'Run this script as root.'
[[ -n "$PHP_BIN" ]] || die 'PHP CLI was not found.'
[[ -f "$PROJECT_ROOT/composer.json" ]] || die "Invalid project root: $PROJECT_ROOT"
[[ -f "$PROJECT_ROOT/.env.example" ]] || die '.env.example is missing; deploy the latest project files first.'

if id "$WEB_USER" >/dev/null 2>&1; then
    WEB_GROUP="$(id -gn "$WEB_USER")"
else
    log "Warning: user '$WEB_USER' was not found; using root ownership."
    WEB_USER=root
    WEB_GROUP=root
fi

install -d -m 700 "$BACKUP_DIR"

if [[ ! -f "$ENV_FILE" ]]; then
    install -m 640 -o root -g "$WEB_GROUP" "$PROJECT_ROOT/.env.example" "$ENV_FILE"
else
    chown root:"$WEB_GROUP" "$ENV_FILE"
    chmod 640 "$ENV_FILE"
fi

read_env_value() {
    local key="$1" line value
    line="$(grep -E "^${key}=" "$ENV_FILE" | tail -n 1 || true)"
    [[ -n "$line" ]] || return 1
    value="${line#*=}"
    if [[ "$value" == \"*\" && "$value" == *\" ]]; then
        value="${value:1:${#value}-2}"
    fi
    [[ -n "$value" ]] || return 1
    printf '%s' "$value"
}

write_env_value() {
    local key="$1" value="$2" escaped line found=0 temp
    [[ "$value" != *$'\n'* && "$value" != *$'\r'* ]] || die "$key must be a single-line value."
    escaped="${value//\\/\\\\}"
    escaped="${escaped//\"/\\\"}"
    temp="$(mktemp)"

    while IFS= read -r line || [[ -n "$line" ]]; do
        if [[ "$line" == "$key="* ]]; then
            if [[ "$found" -eq 0 ]]; then
                printf '%s="%s"\n' "$key" "$escaped" >> "$temp"
                found=1
            fi
        else
            printf '%s\n' "$line" >> "$temp"
        fi
    done < "$ENV_FILE"

    if [[ "$found" -eq 0 ]]; then
        printf '%s="%s"\n' "$key" "$escaped" >> "$temp"
    fi

    install -m 640 -o root -g "$WEB_GROUP" "$temp" "$ENV_FILE"
    rm -f -- "$temp"
}

prompt_required() {
    local key="$1" label="$2" secret="${3:-0}" default_value="${4:-}" value
    if read_env_value "$key" >/dev/null; then
        return
    fi
    [[ -t 0 ]] || die "$key is missing and the script is not running interactively."

    while true; do
        if [[ "$secret" -eq 1 ]]; then
            read -r -s -p "$label: " value
            printf '\n'
        else
            if [[ -n "$default_value" ]]; then
                read -r -p "$label [$default_value]: " value
                value="${value:-$default_value}"
            else
                read -r -p "$label: " value
            fi
        fi
        [[ -n "$value" ]] && break
        log "$label cannot be empty."
    done
    write_env_value "$key" "$value"
}

prompt_optional() {
    local key="$1" label="$2" secret="${3:-0}" value
    if read_env_value "$key" >/dev/null; then
        return
    fi
    [[ -t 0 ]] || return
    if [[ "$secret" -eq 1 ]]; then
        read -r -s -p "$label (leave empty to skip): " value
        printf '\n'
    else
        read -r -p "$label (leave empty to skip): " value
    fi
    [[ -z "$value" ]] || write_env_value "$key" "$value"
}

log 'Configuring project-local environment file.'
prompt_required DB_DSN 'Database DSN' 0 'mysql:host=127.0.0.1;dbname=doctor911'
prompt_required DB_USERNAME 'Database username'
prompt_required DB_PASSWORD 'Database password' 1

if ! read_env_value FRONTEND_COOKIE_VALIDATION_KEY >/dev/null; then
    write_env_value FRONTEND_COOKIE_VALIDATION_KEY "$($PHP_BIN -r 'echo bin2hex(random_bytes(32));')"
fi
if ! read_env_value BACKEND_COOKIE_VALIDATION_KEY >/dev/null; then
    write_env_value BACKEND_COOKIE_VALIDATION_KEY "$($PHP_BIN -r 'echo bin2hex(random_bytes(32));')"
fi

prompt_optional CRM_SUBSCRIBE_KEY 'CRM subscribe key' 1
prompt_optional CRM_SUBSCRIBE_TOKEN 'CRM subscribe token' 1

backup_and_copy() {
    local source="$1" destination="$2" relative
    [[ -f "$source" ]] || die "Missing production template: $source"
    relative="${destination#"$PROJECT_ROOT/"}"
    if [[ -e "$destination" ]]; then
        install -d -m 700 "$BACKUP_DIR/$(dirname -- "$relative")"
        cp -a -- "$destination" "$BACKUP_DIR/$relative"
    fi
    cp -f -- "$source" "$destination"
}

log 'Installing production Yii bootstrap and local config templates.'
backup_and_copy "$PROJECT_ROOT/environments/prod/common/config/main-local.php" "$PROJECT_ROOT/common/config/main-local.php"
backup_and_copy "$PROJECT_ROOT/environments/prod/frontend/config/main-local.php" "$PROJECT_ROOT/frontend/config/main-local.php"
backup_and_copy "$PROJECT_ROOT/environments/prod/backend/config/main-local.php" "$PROJECT_ROOT/backend/config/main-local.php"
backup_and_copy "$PROJECT_ROOT/environments/prod/console/config/main-local.php" "$PROJECT_ROOT/console/config/main-local.php"
backup_and_copy "$PROJECT_ROOT/environments/prod/frontend/web/index.php" "$PROJECT_ROOT/frontend/web/index.php"
backup_and_copy "$PROJECT_ROOT/environments/prod/backend/web/index.php" "$PROJECT_ROOT/backend/web/index.php"
backup_and_copy "$PROJECT_ROOT/environments/prod/yii" "$PROJECT_ROOT/yii"
chmod 755 "$PROJECT_ROOT/yii"

if [[ "${SKIP_COMPOSER:-0}" != 1 ]]; then
    command -v composer >/dev/null 2>&1 || die 'Composer was not found. Set SKIP_COMPOSER=1 only if vendor is already current.'
    log 'Installing locked production dependencies.'
    (cd "$PROJECT_ROOT" && COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction)
fi

log 'Checking PHP configuration syntax.'
"$PHP_BIN" -l "$PROJECT_ROOT/common/config/bootstrap.php" >/dev/null
"$PHP_BIN" -l "$PROJECT_ROOT/common/config/main.php" >/dev/null
"$PHP_BIN" -l "$PROJECT_ROOT/frontend/config/main.php" >/dev/null
"$PHP_BIN" -l "$PROJECT_ROOT/frontend/web/index.php" >/dev/null

RUNTIME_PATHS=(
    "$PROJECT_ROOT/frontend/runtime"
    "$PROJECT_ROOT/backend/runtime"
    "$PROJECT_ROOT/frontend/web/assets"
)
for path in "${RUNTIME_PATHS[@]}"; do
    install -d -o "$WEB_USER" -g "$WEB_GROUP" -m 775 "$path"
    chown -R "$WEB_USER":"$WEB_GROUP" "$path"
done

if command -v runuser >/dev/null 2>&1; then
    runuser -u "$WEB_USER" -- "$PHP_BIN" "$PROJECT_ROOT/yii" cache/flush-all --interactive=0 || true
else
    (cd "$PROJECT_ROOT" && "$PHP_BIN" yii cache/flush-all --interactive=0) || true
fi

PHP_VERSION="$($PHP_BIN -r 'echo PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION;')"
FPM_SERVICE="${PHP_FPM_SERVICE:-php${PHP_VERSION}-fpm}"
FPM_TEST_BIN="$(command -v "php-fpm${PHP_VERSION}" || command -v php-fpm || true)"

if systemctl cat "$FPM_SERVICE.service" >/dev/null 2>&1; then
    if [[ -n "$FPM_TEST_BIN" ]]; then
        "$FPM_TEST_BIN" -t
    fi
    log "Restarting $FPM_SERVICE."
    systemctl restart "$FPM_SERVICE"
else
    log "Warning: $FPM_SERVICE.service was not found; restart the active PHP handler manually."
fi

if systemctl cat nginx.service >/dev/null 2>&1; then
    nginx -t
    systemctl reload nginx
fi

log 'Configuration complete.'
log "Secrets: $ENV_FILE (mode 640, not tracked by Git)"
log "Backups: $BACKUP_DIR"
log 'Check https://doctor911.am/ and https://doctor911.am/captcha now.'
