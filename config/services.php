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
    | a conventional place to find your various credentials.
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

    'cloudfront' => [
        'enabled' => (bool) env('CLOUDFRONT_ENABLED', false),
        'key' => env('AWS_KEY'),
        'secret' => env('AWS_SECRET'),
        'distribution' => env('CLOUDFRONT_DISTRIBUTION'),
        'sdk_version' => env('COULDFRONT_SDK_VERSION'),
        'region' => env('COULDFRONT_REGION')
    ],

    'google_tag_manager' => [
        'enabled' => (bool) env('GTM_ENABLED', false),
        'id' => env('GTM_ID', '')
    ],

];
