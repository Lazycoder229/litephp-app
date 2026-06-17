<?php

declare(strict_types=1);

use Core\Config\Env;

/**
 * Session Configuration
 *
 * Consumed by Session::start() which is called in Bootstrap/app.php.
 *
 * Keys:
 *   name     — Name of the session cookie sent to the browser.
 *   lifetime — Session idle timeout in minutes. After this period of
 *              inactivity, the session is considered expired.
 *   domain   — Cookie domain. Leave empty to use the current host.
 *              Set to '.example.com' to share across subdomains.
 *   samesite — SameSite cookie policy: 'Lax', 'Strict', or 'None'.
 *              'Lax'    — safe default; blocks cross-site POST cookies.
 *              'Strict' — tightest; may break OAuth / payment redirects.
 *              'None'   — required for cross-origin embeds; needs Secure=true.
 *
 * Sessions are stored in: storage/framework/sessions/
 * (configured via session_save_path() in Bootstrap/app.php)
 */
return [
    'name'     => Env::get('SESSION_NAME',     'lite_session'),
    'lifetime' => (int) Env::get('SESSION_LIFETIME', '120'),
    'domain'   => Env::get('SESSION_DOMAIN',   ''),
    'samesite' => Env::get('SESSION_SAMESITE', 'Lax'),
       'secure'   => (bool) Env::get('SESSION_SECURE_COOKIE', false),
       'http_only'=> true,
];
