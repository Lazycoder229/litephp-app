<?php

/**
 * Application Entry Point
 *
 * All HTTP requests are routed through this file by the web server
 * (.htaccess for Apache, try_files for Nginx).
 *
 * Execution order:
 *   1. Set the default timezone for the application.
 *   2. Load the autoloader (APP_BASE_PATH, Composer, App\ namespace).
 *   3. Run the framework's Bootstrap/app.php (shipped inside
 *      vendor/litephp/core) which boots the framework and handles
 *      the request through the middleware pipeline and router.
 *
 * Do not add application logic here. Use routes, controllers, or
 * middleware instead.
 */

date_default_timezone_set('Asia/Manila');



require __DIR__ . '/../autoload.php';
require __DIR__ . '/../app/bootstrap.php'; // ← dagdag dito
require __DIR__ . '/../vendor/litephp/core/Core/Bootstrap/app.php';