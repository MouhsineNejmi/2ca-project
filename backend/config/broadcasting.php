<?php

return [
  'pusher' => [
    'driver' => env('BROADCAST_DRIVER'),
    'app_id' => env('PUSHER_APP_ID'),
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => true,
    ],
  ],
];