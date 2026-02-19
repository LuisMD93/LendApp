<?php


use Infrastructure\Http\Core\Router;
use Shared\Helpers\Response;

$router = new Router();

// Si llegamos aquí, es porque es la raíz o el endpoint principal
if ($router->url === '') {
    Response::success(true, "Bienvenido a mi app (LendApp API)", 200);
    return;
}else{
    Response::success(false, "The resource you are trying to access does not exist", 404);
    return;
}

