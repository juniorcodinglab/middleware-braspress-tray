<?php
$config = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini', TRUE);
$statusProject = $config['status'];
$configApp = $config[$statusProject['database-config']];

return [
    'settings' => [
        'displayErrorDetails' => $configApp['displayErrorDetails'], // set to false in production
        'addContentLengthHeader' => $configApp['addContentLengthHeader'], // Allow the web server to send the content-length header
        
        // Monolog settings
        'logger' => [
            'name' => 'middleware',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
            'maxFiles' => 7,
        ],
        "api" => [
            "apiUrl" => $configApp['braspressUrl'],
            "apiUser" => $configApp['braspressUser'],
            "apiPass" => $configApp['braspressPass'],
        ]
    ],
];
