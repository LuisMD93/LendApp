<?php


require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/Container.php';
require_once __DIR__ . '/../config/Services/ContainerConfigurator.php';
#require_once __DIR__ . '/../Routes/UsersEndPoints/userRoutes.php';

use Infrastructure\Middlewares\CorsMiddleware;

// Ejecutar CORS primero
$cors = new CorsMiddleware();
$cors->handle();

require_once __DIR__ . '/../Routes/loadRoutes.php';


