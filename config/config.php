<?php

$envFile = dirname(__DIR__) . '/.env';

require_once __DIR__ . '/loadEnv.php';

// Retornar la configuración de la base de datos
return [
    'database' => [
        'host' => getenv('DB_HOST') ,
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD') ,
        'dbname' => getenv('DB_NAME'),
        'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    ],
    'secretKey' => getenv('SECRET_KEY') ?: 'default_secret',
];