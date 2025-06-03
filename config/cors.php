<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'storage/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:59287',
        'http://localhost:61937',
        // Add other ports you use during development
    ], // atau ganti dengan origin Flutter kamu

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
