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
 *   3. Run Bootstrap/app.php which boots the framework and handles
 *      the request through the middleware pipeline and router.
 *
 * Do not add application logic here. Use Bootstrap/app.php, routes,
 * controllers, or middleware instead.
 */

date_default_timezone_set('Asia/Manila');

define('APP_BASE_PATH', dirname(__DIR__));  // ← IDAGDAG ITO

require __DIR__ . '/../../autoload.php';    // ← AYUSIN ANG SLASH
require __DIR__ . '/../Bootstrap/app.php';
