<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', env('APP_URL').'/auth/google/callback'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI', env('APP_URL').'/auth/facebook/callback'),
    ],

    'paymongo' => [
        'secret_key' => env('PAYMONGO_SECRET_KEY'),
        'public_key' => env('PAYMONGO_PUBLIC_KEY'),
        'webhook_secret' => env('PAYMONGO_WEBHOOK_SECRET'),
    ],

    'maya' => [
        'public_key' => env('MAYA_PUBLIC_KEY'),
        'secret_key' => env('MAYA_SECRET_KEY'),
        'checkout_url' => env('MAYA_CHECKOUT_URL', 'https://pg-sandbox.paymaya.com/checkout/v1/checkouts'),
    ],

    'lalamove' => [
        'api_key' => env('LALAMOVE_API_KEY'),
        'api_secret' => env('LALAMOVE_API_SECRET'),
        'base_url' => env('LALAMOVE_BASE_URL', 'https://rest.sandbox.lalamove.com'),
        'market' => env('LALAMOVE_MARKET', 'PH'),
        'language' => env('LALAMOVE_LANGUAGE', 'en_PH'),
        'service_type' => env('LALAMOVE_SERVICE_TYPE', 'MOTORCYCLE'),
        'pickup_name' => env('LALAMOVE_PICKUP_NAME', 'Printify & Co.'),
        'pickup_phone' => env('LALAMOVE_PICKUP_PHONE', '+639000000000'),
        'pickup_address' => env('LALAMOVE_PICKUP_ADDRESS', 'Makati City, Metro Manila, Philippines'),
        'pickup_lat' => env('LALAMOVE_PICKUP_LAT', '14.554729'),
        'pickup_lng' => env('LALAMOVE_PICKUP_LNG', '121.024445'),
    ],

];
