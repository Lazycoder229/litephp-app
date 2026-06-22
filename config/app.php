<?php

declare(strict_types=1);

use Core\Config\Env;

/**
 * Application Configuration
 *
 * Core application settings. All values can be overridden via .env.
 *
 * Keys:
 *   name   — Application display name. Used in views and email subjects.
 *   env    — Environment: 'local', 'staging', or 'production'.
 *   debug  — When true, detailed error pages are shown. Set false in production.
 *   url    — The base URL of the application (no trailing slash).
 *            Used by url(), asset(), and redirect helpers.
 */
return [
    'name'  => Env::get('APP_NAME', 'Lite'),

    'env'   => Env::get('APP_ENV', 'production'),

    'debug' => filter_var(
        Env::get('APP_DEBUG', false),
        FILTER_VALIDATE_BOOL
    ),

    'url'   => rtrim(
        Env::get('APP_URL', 'http://localhost:3000'),
        '/'
    ),

    'timezone' => Env::get('APP_TIMEZONE', 'UTC'),

    'locale'   => Env::get('APP_LOCALE', 'en'),
      'trusted_proxies' => array_filter(
        array_map('trim', explode(',', env('APP_TRUSTED_PROXIES', '')))
    ),
];