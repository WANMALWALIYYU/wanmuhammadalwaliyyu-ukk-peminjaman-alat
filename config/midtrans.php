<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration (Sandbox Mode)
    |--------------------------------------------------------------------------
    */

    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

    'notification_url' => env('MIDTRANS_NOTIFICATION_URL'),
    'finish_url' => env('MIDTRANS_FINISH_URL'),
    'unfinish_url' => env('MIDTRANS_UNFINISH_URL'),
    'error_url' => env('MIDTRANS_ERROR_URL'),
];
