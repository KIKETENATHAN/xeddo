<?php

return [
    /*
    |--------------------------------------------------------------------------
    | M-Pesa Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for M-Pesa STK Push integration
    |
    */

    'consumer_key' => env('MPESA_CONSUMER_KEY', 'your_consumer_key'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET', 'your_consumer_secret'),
    'shortcode' => env('MPESA_SHORTCODE', '174379'),
    'passkey' => env('MPESA_PASSKEY', 'your_passkey'),
    'base_url' => env('MPESA_BASE_URL', 'https://sandbox.safaricom.co.ke'),
];
