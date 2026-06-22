<?php

declare(strict_types=1);

use Core\Config\Env;

/**
 * Database Configuration
 *
 * Supports multiple named connections. The 'default' key selects
 * which connection is used by Core\Database and the ORM.
 *
 * Connection options:
 *   host      — Database server hostname or IP.
 *   port      — Database server port (MySQL default: 3306).
 *   database  — Database / schema name to connect to.
 *   username  — Database user.
 *   password  — Database password. Leave empty for no password.
 *   charset   — Character set for the connection (recommended: utf8mb4).
 *
 * All values read from .env — never hardcode credentials here.
 *
 * Example .env:
 *   DB_HOST=127.0.0.1
 *   DB_PORT=3306
 *   DB_DATABASE=my_app
 *   DB_USERNAME=root
 *   DB_PASSWORD=secret
 */

return [
    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'driver'     => 'mysql',
            'host'       => env('DB_HOST',     '127.0.0.1'),
            'port'       => env('DB_PORT',     '3306'),
            'database'   => env('DB_DATABASE', 'lite'),
            'username'   => env('DB_USERNAME', 'root'),
            'password'   => env('DB_PASSWORD', ''),
            'charset'    => 'utf8mb4',
            'prefix'     => '',
            // SECURITY FIX: persistent connections are OFF by default to prevent
            // connection pool exhaustion (DoS risk). Set to true only for CLI workers.
            'persistent' => (bool) env('DB_PERSISTENT', false),
        ],
    ],
];
