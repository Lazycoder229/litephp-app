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
    'default' => Env::get('DB_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'host'     => Env::get('DB_HOST', '127.0.0.1'),
            'port'     => Env::get('DB_PORT', '3306'),
            'database' => Env::get('DB_DATABASE'),
            'username' => Env::get('DB_USERNAME'),
            'password' => Env::get('DB_PASSWORD', ''),
            'charset'  => Env::get('DB_CHARSET', 'utf8mb4'),
        ],
    ],
];
