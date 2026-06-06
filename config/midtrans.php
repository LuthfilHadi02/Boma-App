<?php

// File ini dibuat manual — letakkan di: config/midtrans.php
// Nilai diambil dari .env supaya key tidak hardcode di code

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
];