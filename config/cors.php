<?php

declare(strict_types=1);

use Core\Config\Env;

return [
    'allowed_origins' => array_map(
        'trim',
        explode(',', Env::get('CORS_ALLOWED_ORIGINS', 'http://localhost:3000'))
    ),

    'allowed_methods' => ['GET','POST','PUT','PATCH','DELETE','OPTIONS'],

    'allowed_headers' => ['Content-Type','Authorization'],

    'allow_credentials' => false,

    'max_age' => 86400,
];