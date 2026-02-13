<?php
// loadRoutes.php

// loadRoutes.php

// Usamos __DIR__ para asegurar que partimos desde donde está este archivo
$routesBase = realpath(__DIR__ . '/../src/Infrastructure/Http');

if (!$routesBase || !is_dir($routesBase)) {
    // Esto saldrá en los logs de Render si la ruta está mal
    error_log("Error: No se encontró la carpeta de rutas en " . __DIR__ . '/../src/Infrastructure/Http');
    return;
}

function loadAllRoutes($dir) {
    if (!is_dir($dir)) return;
    
    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        if (is_dir($path)) {
            loadAllRoutes($path);
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

