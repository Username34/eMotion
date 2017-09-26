<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        // mysql settings
        'mysql' => [
            'server' => '149.202.51.26',
            'user' => 'user',
            'pass' => 'emotion',
            'database' => 'emotion'
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => '149.202.51.26',
            'database' => 'emotion',
            'username' => 'user',
            'password' => 'emotion',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];