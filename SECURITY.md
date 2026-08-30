# Security configuration

Production secrets must be supplied by the process environment and must not be committed to Git.

Required variables:

- `DB_DSN` (for example, `mysql:host=127.0.0.1;dbname=doctor911`)
- `DB_USERNAME` (use a least-privileged application account, not `root`)
- `DB_PASSWORD`
- `FRONTEND_COOKIE_VALIDATION_KEY` (a new random value of at least 32 bytes)
- `BACKEND_COOKIE_VALIDATION_KEY` (a different new random value of at least 32 bytes)
- `CRM_SUBSCRIBE_KEY`
- `CRM_SUBSCRIBE_TOKEN`
- `ARCA_USERNAME` and `ARCA_PASSWORD` if the legacy ARCA integration is used
- `SMS_BROKER_URL`, `SMS_BROKER_LOGIN`, and `SMS_BROKER_PASSWORD` if the legacy SMS integration is used; the URL must be HTTPS

Optional variable:

- `CRM_SUBSCRIBE_URL` (defaults to the Doctor911 HTTPS CRM endpoint)
- `TRUSTED_PROXY_CIDRS` (comma-separated proxy CIDRs; defaults to Cloudflare's published HTTP proxy ranges, and an explicitly empty value disables proxy-header trust)

The database password, cookie key, CRM credentials, legacy ARCA credentials, and SMS credentials that previously appeared in the repository must be rotated before deployment. Removing them from the latest commit does not remove them from Git history.

The public appointment limiter uses `Request::getUserIP()`. If the site is behind a reverse proxy or CDN, configure Yii `trustedHosts` and `ipHeaders` for only the proxy ranges you control; otherwise all visitors may appear to share a proxy address.

The bundled defaults trust `CF-Connecting-IP` only when the immediate peer belongs to Cloudflare's published proxy ranges. Keep those ranges current and restrict origin HTTP/HTTPS traffic to Cloudflare at the firewall so attackers cannot bypass CDN protections.

CSRF validation is required for both frontend forms and authenticated backend CRUD actions. Do not disable it globally in a controller.

Application log targets deliberately do not dump `$_POST`, cookies, or server globals. Security events must log only non-sensitive metadata or keyed fingerprints, never names, phone numbers, credentials, CAPTCHA values, or CSRF tokens.
