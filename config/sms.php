<?php

return [
    'rest' => [
        'key' => env('LBSMS_KEY'),
        'username' => env('LBSMS_USERNAME'),
        'password' => env('LBSMS_PASSWORD'),
        'api_header_key' => env('LBSMS_API_HEADER_KEY'),
    ],
    'http' => [
        'url' => env('DIALOG_SMS_URL'),
        'sms_key' => env('DIALOG_SMS_KEY'),
        'mask' => env('DIALOG_SMS_MASK'),
    ]
];
