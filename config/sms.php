<?php

return [
    'rest' => [
        'key' => env('LBSMS_KEY'),
        'username' => env('LBSMS_USERNAME'),
        'password' => env('LBSMS_PASSWORD'),
        'api_header_key' => env('LBSMS_API_HEADER_KEY'),
    ],
    'http' => [
        'url' => env('LBSMS_HTTP_URL'),
        'company_id' => env('LBSMS_HTTP_COMPANY_ID'),
        'password' => env('LBSMS_HTTP_PASSWORD'),
    ]
];
