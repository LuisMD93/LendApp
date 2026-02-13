<?php
/**
 * Autoload función para cargar las clases automáticamente.
 *
 * @param string $class El nombre completo de la clase a cargar (incluido el espacio de nombres).
 */
function autoload($className) {
    $baseDir = __DIR__ . '/../src/'; // Ruta base de tus archivos fuente
    $classFile = $baseDir . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    }
}

//spl_autoload_register('autoload');
// Registra la función autoload
spl_autoload_register('autoload');