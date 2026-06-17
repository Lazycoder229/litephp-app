<?php

declare(strict_types=1);

use Core\Config\Env;

/**
 * Mail Configuration
 *
 * Consumed by Core\Mail\Mailer and Core\Mail\Mailable.
 *
 * Keys:
 *   driver      — Mail transport: 'smtp' or 'sendmail'.
 *   host        — SMTP server hostname.
 *   port        — SMTP port (587 for TLS, 465 for SSL, 25 for plain).
 *   username    — SMTP account username.
 *   password    — SMTP account password.
 *   encryption  — 'tls', 'ssl', or '' for none.
 *   from        — Default sender address and name used in all outgoing mail.
 */
return [
    'driver'     => Env::get('MAIL_DRIVER', 'smtp'),
    'host'       => Env::get('MAIL_HOST',   'smtp.mailtrap.io'),
    'port'       => (int) Env::get('MAIL_PORT', '587'),
    'username'   => Env::get('MAIL_USERNAME', ''),
    'password'   => Env::get('MAIL_PASSWORD', ''),
    'encryption' => Env::get('MAIL_ENCRYPTION', 'tls'),
    'from'       => [
        'address' => Env::get('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name'    => Env::get('MAIL_FROM_NAME',    'Lite'),
    ],
];