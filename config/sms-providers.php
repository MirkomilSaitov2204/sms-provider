<?php

return [
    'default' => env('SMS_DEFAULT_PROVIDER', 'fake'),

    'providers' => [
        'eskiz' => [
            'base_url' => env('SMS_ESKIZ_BASE_URL'),
            'api_key' => env('SMS_ESKIZ_API_KEY'),
        ],
        'playmobile' => [
            'base_url' => env('SMS_PLAYMOBILE_BASE_URL'),
            'login' => env('SMS_PLAYMOBILE_LOGIN'),
            'password' => env('SMS_PLAYMOBILE_PASSWORD'),
        ],
        'fake' => [
            'enabled' => true,
        ],
    ],
];
