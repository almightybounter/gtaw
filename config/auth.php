<?php

return [

    // Auth defaults
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    // Guards
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    // User providers
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    // Password reset
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    // Password confirmation timeout
    'password_timeout' => 10800,

]; 