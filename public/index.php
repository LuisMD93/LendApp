<?php
// MOSTRAR ERRORES PARA DEBBUG (Solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/Container.php';
require_once __DIR__ . '/../config/Services/ContainerConfigurator.php';
#require_once __DIR__ . '/../Routes/UsersEndPoints/userRoutes.php';

use Infrastructure\Middlewares\CorsMiddleware;

// Ejecutar CORS primero
$cors = new CorsMiddleware();
$cors->handle();

require_once __DIR__ . '/../Routes/loadRoutes.php';


