<?php

declare(strict_types=1);

use Core\Config\Env;

/**
 * CORS Configuration
 *
 * Used by CorsMiddleware (app/Middleware/Web/CorsMiddleware.php).
 *
 * Keys:
 *   allowed_origins — List of origins permitted to make cross-origin requests.
 *                     Set CORS_ALLOWED_ORIGINS in .env as a comma-separated list.
 *                     Example: http://localhost:5173,https://app.example.com
 *                     Use * only in development — never in production.
 *
 * For additional CORS settings (methods, headers, credentials, max_age),
 * extend this file and update CorsMiddleware to read them.
 */
return [
    'allowed_origins' => array_filter(
        explode(',', Env::get('CORS_ALLOWED_ORIGINS', 'http://localhost:3000'))
    ),
];
