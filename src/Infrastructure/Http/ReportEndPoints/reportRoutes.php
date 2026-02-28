<?php
#reportRoutes.php

use Infrastructure\Http\Core\Router;
use Infrastructure\Controllers\ReportController;
use Shared\Helpers\Response;
use Shared\Mapping\ReportMapper;
use config\Container;
use Infrastructure\Middlewares\AuthMiddleware;
use config\Services\ContainerConfigurator;
use Shared\Helpers\Constants\Constans;

$router = new Router();

if (!str_starts_with($router->url, 'report')) {
    Response::success(true, "Bienvenido a mi app (LendApp API) By Luis Solis ".$router->url.' report', 200);
    return;
}

$container = new Container();
ContainerConfigurator::configure($container);
$auth = $container->get(AuthMiddleware::class);
$controller = $container->get(ReportController::class);
$headers = $router->getHeaders();

switch ($router->method) {
    case 'GET':
        switch ($router->url) {
            case 'report/gets':
                $controller->show();
                break;
            case 'report':
                echo "Módulo reporte";
                break;
            default:
                echo "Ruta GET no encontrada: '$router->url'";
        }
        break;
        case 'POST':
        switch ($router->url) {
            case 'report/Add':
                    
                // header('Content-Type: application/json; charset=utf-8');

                // $input = file_get_contents('php://input');
                // $data = json_decode($input, true); // true = array asociativo

                // // Ver lo que llega
                // // echo '<pre>'; var_dump($data); echo '</pre';

                // echo json_encode([
                //     "status" => "ok",
                //     "location" => $data["location"] ,
                //     "cantidad" => $data["amount"] ,
                //     "descripcion" => $data["description"] ,
                //     "estado prestamo" => $data["lendStatus"] ,
                //     "nombre producto" => $data["name"]
                // ]);
                    $isValid = $auth->isValidJWT($headers);
                    if(!$isValid){  
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }

                    $isAdmin = $auth->checkAdmin($headers);
                    if (!$isAdmin) {
                       Response::error(false,Constans::ERROR_MESSAGE_ACCESS,403);
                    }

                    $isExperation = $auth->ValidateTokenExpiration($headers);
                    if($isExperation){
                       $controller->save(ReportMapper::fromArray(Response::arrayParse('php://input')));
                    }else{
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }

                
                break;
            case 'report/login':                  
                 $controller->login(ReportMapper::fromArray(Response::arrayParse('php://input')));
                break;
            default:
                echo "Ruta GET no encontrada: '$router->url'";
        }

        break;
        case 'DELETE':
        switch ($router->url) {
            case 'report/delete':
                    $isValid = $auth->isValidJWT($headers);
                    if(!$isValid){  
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }

                    $isAdmin = $auth->checkAdmin($headers);
                    if (!$isAdmin) {
                       Response::error(false,Constans::ERROR_MESSAGE_ACCESS,403);
                    }

                    $isExperation = $auth->ValidateTokenExpiration($headers);
                    if($isExperation){
                       #$controller->delete($router->queryParams['id']);
                    }else{
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }
                  
                break;
            default:
                echo "Ruta GET no encontrada: '$router->url'";
        }
        
        break;
        case 'PUT':
        switch ($router->url) {
            case 'report/pay':
                    $isValid = $auth->isValidJWT($headers);
                    if(!$isValid){  
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }

                    $isAdmin = $auth->checkAdmin($headers);
                    if (!$isAdmin) {
                       Response::error(false,Constans::ERROR_MESSAGE_ACCESS,403);
                    }

                    $isExperation = $auth->ValidateTokenExpiration($headers);
                    if($isExperation){
                       #$controller->changeStatus($router->queryParams['id']);
                    }else{
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }                 
                break;
            case 'report/update':
                    $isValid = $auth->isValidJWT($headers);
                    if(!$isValid){  
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }

                    $isAdmin = $auth->checkAdmin($headers);
                    if (!$isAdmin) {
                       Response::error(false,Constans::ERROR_MESSAGE_ACCESS,403);
                    }

                    $isExperation = $auth->ValidateTokenExpiration($headers);
                    if($isExperation){
                       $controller->update(ReportMapper::fromArray(Response::arrayParse('php://input')));
                    }else{
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }
                       
                break;
            default:
                echo "Ruta GET no encontrada: '$router->url'";
        }
        
        break;
        case 'PATCH':
        switch ($router->url) {
            case 'report/pay':
                    $isValid = $auth->isValidJWT($headers);
                    if(!$isValid){  
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }

                    $isAdmin = $auth->checkAdmin($headers);
                    if (!$isAdmin) {
                       Response::error(false,Constans::ERROR_MESSAGE_ACCESS,403);
                    }

                    $isExperation = $auth->ValidateTokenExpiration($headers);
                    if($isExperation){
                       $controller->update(ReportMapper::fromArray(Response::arrayParse('php://input')));
                    }else{
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }
                  
                break;
            default:
                echo "Ruta GET no encontrada: '$router->url'";
        }
        
        break;
        
    default:
        echo "Método HTTP no soportado";
}
