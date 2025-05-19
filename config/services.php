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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'webhook' => [
        'secret' => env('WEBHOOK_SECRET', 'secret'),
    ],

    'telegram_bot' => [
        'username' => env('TELEGRAM_BOT_USERNAME'),
        'token' => env('TELEGRAM_BOT_TOKEN'),
        'api' => 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN'),
        'webhook_url' => env('TELEGRAM_BOT_WEBHOOK_UR', env('APP_URL').'/telegram/hook'),
    ],
];
