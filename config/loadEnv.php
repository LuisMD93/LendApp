<?php
// config/loadEnv.php

$envFile = __DIR__ . '/../.env'; // ajusta la ruta según donde esté tu .env

if (!file_exists($envFile)) {
    die('El archivo .env no existe en la raíz del proyecto.');
}

// Leer archivo .env línea por línea
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    $line = trim($line);

    // Ignorar comentarios y líneas vacías
    if ($line === '' || $line[0] === '#') continue;

    // Validar formato KEY=VALUE
    if (!str_contains($line, '=')) continue;

    list($key, $value) = explode('=', $line, 2);

    $key = trim($key);
    $value = trim($value);

    // Guardar en variables de entorno
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}
