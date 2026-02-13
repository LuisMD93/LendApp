<?php
/**
 * Autoload función para cargar las clases automáticamente.
 *
 * @param string $class El nombre completo de la clase a cargar (incluido el espacio de nombres).
 */
// function autoload($className) {
//     $baseDir = __DIR__ . '/../src/'; // Ruta base de tus archivos fuente
//     $classFile = $baseDir . str_replace('\\', '/', $className) . '.php';
//     if (file_exists($classFile)) {
//         require_once $classFile;
//     }
// }

// //spl_autoload_register('autoload');
// // Registra la función autoload
// spl_autoload_register('autoload');

function autoload($className) {
    // 1. Definimos la raíz real del proyecto (un nivel arriba de config)
    $projectRoot = realpath(__DIR__ . '/../'); 
    
    // 2. Intentamos buscar en /src (Para Infrastructure, Domain, Application)
    $classFile = $projectRoot . '/src/' . str_replace('\\', '/', $className) . '.php';
    
    // 3. Si no está en /src, intentamos buscar desde la raíz (Para la carpeta /config)
    if (!file_exists($classFile)) {
        $classFile = $projectRoot . '/' . str_replace('\\', '/', $className) . '.php';
    }

    if (file_exists($classFile)) {
        require_once $classFile;
    } else {
        // Esto ayudará a ver en los logs de Render qué ruta está intentando cargar y falla
        // error_log("Autoload falló: " . $classFile);
         error_log("DEBUG AUTOLOAD: No se encontro la clase [$className] en la ruta [$classFile]");
    }
}

// // Registra la función autoload
spl_autoload_register('autoload');