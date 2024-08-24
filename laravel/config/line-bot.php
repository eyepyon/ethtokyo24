<?php

return [
    'channel_access_token' => env('LINE_BOT_CHANNEL_ACCESS_TOKEN'),
    'channel_id' => env('LINE_BOT_CHANNEL_ID'),
    'channel_secret' => env('LINE_BOT_CHANNEL_SECRET'),
    'client' => [
        'config' => [
          'headers' => ['X-Foo' => 'Bar'],
        ],
    ],
];


