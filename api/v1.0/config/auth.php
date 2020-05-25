<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        'admins' => [
            'driver' => 'jwt',
            'provider' => 'master_user',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\User::class
        ],
        'master_user' => [
            'driver' => 'eloquent',
            'model' => \App\MasterUser::class
        ]
    ]
];
