<?php

return [
    'client_password' => env('SEED_CLIENT_PASSWORD'),
    'admin' => [
        'name' => env('SEED_ADMIN_NAME', 'Administração local'),
        'email' => env('SEED_ADMIN_EMAIL'),
        'password' => env('SEED_ADMIN_PASSWORD'),
    ],
];
