<?php

$projectRoot = dirname(dirname(__DIR__));
$envFile = $projectRoot . '/.env';

// Production may keep secrets in a project-local, Git-ignored .env file.
// Real process environment variables take precedence, and tests never load it.
if ((!defined('YII_ENV_TEST') || !YII_ENV_TEST) && is_file($envFile)) {
    if (!is_readable($envFile) || filesize($envFile) > 65536) {
        throw new RuntimeException('The application environment file is not readable or is unexpectedly large.');
    }

    $variables = @parse_ini_file($envFile, false, INI_SCANNER_RAW);
    if ($variables === false) {
        throw new RuntimeException('The application environment file is invalid.');
    }

    foreach ($variables as $name => $value) {
        if (!preg_match('/^[A-Z][A-Z0-9_]*$/', $name) || !is_string($value)) {
            throw new RuntimeException('The application environment file contains an invalid entry.');
        }

        if (getenv($name) !== false) {
            continue;
        }

        putenv($name . '=' . $value);
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
