<?php
// loadRoutes.php

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

loadAllRoutes($routesBase);

