<?php

// $envFile = dirname(__DIR__) . '/.env';

// require_once __DIR__ . '/loadEnv.php';

// // Retornar la configuración de la base de datos
// return [
//     'database' => [
//         'host' => getenv('DB_HOST') ,
//         'user' => getenv('DB_USER'),
//         'password' => getenv('DB_PASSWORD') ,
//         'dbname' => getenv('DB_NAME'),
//         'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
//     ],
//     'secretKey' => getenv('SECRET_KEY') ?: 'default_secret',
// ];

// Usa getenv() para leer lo que acabas de poner en Render
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

// ¡IMPORTANTE! El DSN debe empezar con pgsql:
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa"; 
} catch (PDOException $e) {
    // Si falla, revisa los logs en Render
    error_log("Error de DB: " . $e->getMessage());
    die("Error al conectar con la base de datos.");
}