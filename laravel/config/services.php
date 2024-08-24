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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],


    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_CALLBACK_URL'),
    ],

//    'line' => [
//        'client_id' => env('LINE_CLIENT_ID'),
//        'client_secret' => env('LINE_CLIENT_SECRET'),
//        'redirect' => env('LINE_REDIRECT_URI')
//    ],

    'line' => [
        'message' => [
            'channel_id'=>env('LINE_BOT_CHANNEL_ID'),
            'channel_secret'=>env('LINE_BOT_CHANNEL_SECRET'),
    	    'channel_token'=>env('LINE_BOT_CHANNEL_ACCESS_TOKEN')
	    ],
        'client_id' => env('LINE_CLIENT_ID'),
        'client_secret' => env('LINE_CLIENT_SECRET'),
        'redirect' => env('LINE_REDIRECT_URI'),
    ],

    'anthropic' => [
        'apikey' => env('ANTHROPIC_API_KEY'),
    ],

    'withings' => [
        'client_id' => env('WITHINGS_CLIENT_ID'),
        'client_secret' => env('WITHINGS_CLIENT_SECRET'),
        'redirect' => env('WITHINGS_REDIRECT_URI'),
        'callback_url' => env('WITHINGS_CALLBACK_URL'),
        'api_endpoint' => env('WITHINGS_API_ENDPOINT')
    ],
];
