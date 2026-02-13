<?php
// loadRoutes.php

// Routes/loadRoutes.php

// 1. Usamos realpath para que Linux no se pierda. 
// __DIR__ es /var/www/html/Routes, así que subimos uno y entramos a src...

// Routes/loadRoutes.php

// 1. Ruta absoluta hacia donde moviste los archivos
$routesBase = realpath(__DIR__ . '/../src/Infrastructure/Http');

if (!$routesBase) {
    // Si ves este error en los logs de Render, revisa las mayúsculas de tus carpetas
    error_log("ERROR: No se encontro la carpeta en: " . __DIR__ . '/../src/Infrastructure/Http');
    return;
}

function loadAllRoutes($dir) {
    if (!is_dir($dir)) return;

    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        if (is_dir($path)) {
            loadAllRoutes($path); // Entra en UserEndPoints y ReportEndPoints
        } else if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            require_once $path;
        }
    }
}

loadAllRoutes($routesBase);
/*
// Base de las rutas dentro de Infrastructure
$routesBase = __DIR__ . '/../src/Infrastructure/Http';


// Función recursiva para cargar todos los .php dentro de Routes
function loadAllRoutes($dir) {
    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $dir . '/' . $item;

        if (is_dir($path)) {
            loadAllRoutes($path); // Recursivo
        } else if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            #echo $path.'<br>';
            require_once $path;
        }
    }
}

loadAllRoutes($routesBase);*/

