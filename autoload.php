<?php

/**
 * Application Autoloader
 *
 * Responsibilities:
 *  1. Defines APP_BASE_PATH — the absolute path to the project root.
 *     Used by path helpers (base_path, storage_path, etc.) in the core.
 *  2. Loads Composer's autoloader, which handles the Core\ namespace
 *     (litephp/core) and any other Composer packages.
 *  3. Registers an SPL autoloader for the App\ namespace, mapping it
 *     to the /app directory so user code is resolved without Composer.
 *
 * Namespace → directory mapping:
 *   App\Controllers\HomeController  →  app/Controllers/HomeController.php
 *   App\Models\User                 →  app/Models/User.php
 *   App\Services\AuthService        →  app/Services/AuthService.php
 */

define('APP_BASE_PATH', __DIR__);

// Composer handles Core\ (litephp/core) and all third-party packages.
require __DIR__ . '/vendor/autoload.php';

// Register App\ namespace manually — no Composer dump-autoload needed
// when adding new app classes during development.
spl_autoload_register(function (string $class): void {
    $prefix  = 'App\\';
    $baseDir = __DIR__ . '/app/';
    $len     = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, substr($class, $len)) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
