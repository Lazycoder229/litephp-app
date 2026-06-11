<?php
// router.php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Block direct access to internal app folders/files
$blocked = [
    '/.env',
    '/.env.example',
    '/composer.json',
    '/composer.lock',
    '/.git',
    '/.htaccess',
    '/vendor',
    '/Core',
    '/Bootstrap',
    '/config',
    '/storage',
    '/resources',
    '/app',
    '/router.php',
    '/autoload.php',
    '/package.json',
    '/package-lock.json',
    '/vite.config.js',
    '/node_modules',
];

foreach ($blocked as $b) {
    if ($uri === $b || str_starts_with($uri, $b . '/')) {
        http_response_code(403);
        exit('Forbidden');
    }
}

// Serve real static assets directly (e.g. /public/assets/litelogo.png)
if (
    (str_starts_with($uri, '/public/') || str_starts_with($uri, '/build/'))
    && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)
) {
    return false;
}

// Everything else → app entry point (handles its own routing)
require __DIR__ . '/index.php';