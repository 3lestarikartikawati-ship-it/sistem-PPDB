<?php

return [
    'client_id' => env('DOKU_CLIENT_ID', ''),
    'secret_key' => env('DOKU_SECRET_KEY', ''),
    'base_url' => env('DOKU_BASE_URL', 'https://api-sandbox.doku.com'),
    'notification_url' => env('DOKU_NOTIFICATION_URL', 'http://localhost:8000/api/doku/notification'),
];
