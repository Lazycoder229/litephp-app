<?php

declare(strict_types=1);

use Core\Config\Env;

/**
 * Authentication Configuration
 *
 * Consumed by Auth::configure() in Bootstrap/app.php at startup.
 *
 * Keys:
 *   model          — Fully-qualified class name of the User model.
 *                    Defaults to App\Models\User. Override via AUTH_MODEL in .env
 *                    if your model lives in a different namespace.
 *   username_field — The database column used as the login identifier.
 *   password_field — The database column that stores the hashed password.
 *   jwt_secret     — Secret key for signing JWT tokens (JwtGuard).
 *                    Set APP_JWT_SECRET in .env. Falls back to APP_KEY.
 *   jwt_ttl        — JWT token lifetime in seconds. Default: 3600 (1 hour).
 *   token_column   — Column used by TokenGuard for API Bearer token lookup.
 *
 * Usage in a controller:
 *   Auth::attempt(['email' => $email, 'password' => $password]);
 *   Auth::user();      // returns array|null
 *   Auth::check();     // returns bool
 *   Auth::logout();
 */
return [
    'model'          => Env::get('AUTH_MODEL', 'App\\Models\\User'),
    'username_field' => 'email',
    'password_field' => 'password',
    'jwt_secret'     => Env::get('APP_JWT_SECRET', Env::get('APP_KEY', '')),
    'jwt_ttl'        => (int) Env::get('JWT_TTL', '3600'),
    'token_column'   => 'api_token',
];
