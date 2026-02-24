<?php
#userRoutes.php

use Infrastructure\Http\Core\Router;
use Infrastructure\Controllers\UserController;
use Shared\Helpers\Response;
use Shared\Mapping\UserMapper;
use config\Container;
use config\Services\ContainerConfigurator;
use Infrastructure\Middlewares\AuthMiddleware;
use Application\Exceptions\InvalidCredentialsException;
use Shared\Helpers\Constants\Constans;



$router = new Router();
if (!str_starts_with($router->url, 'user')) {
    Response::success(true, "Bienvenido a mi app (LendApp API)", 200);
    return;
}

$container = new Container();
ContainerConfigurator::configure($container);

$controller = $container->get(UserController::class);
$auth = $container->get(AuthMiddleware::class);

$headers = $router->getHeaders();

switch ($router->method) {
    case 'GET':
        switch ($router->url) {
            case '':
                echo "principal..";
                break;
            case 'user':
                echo "Módulo usuarios";
                break;
            case 'users':

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
                        $controller->show();
                    }else{
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }
                break;
            case 'usersByPhone':
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
                       $phone = $headers['param'];
                       $controller->getByPhone($phone);
                       #$controller->update(UserMapper::fromArray(Response::arrayParse('php://input')));
                    }else{
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }
                
                break;
            case 'usersUpdateById':
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
                       $controller->update(UserMapper::fromArray(Response::arrayParse('php://input')));
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
            case 'usersUpdateById':
                $controller->update(UserMapper::fromArray(Response::arrayParse('php://input')));
                break;
            default:
                echo "Ruta PUT no encontrada: '$router->url'";
        }
        break;
    case 'POST':
        switch ($router->url) {
            case 'user/Add':
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
                      $controller->save(UserMapper::fromArray(Response::arrayParse('php://input')));
                    }else{
                        Response::error(false,Constans::ERROR_MESSAGE_TOKEN,401);
                    }
                       
                break;
            case 'user/login':
                
                try {
                      return Response::success(
                                                true,
                                                Constans::RESPONSE_SUCCESS,
                                                200,
                                                $auth->authMiddleware($headers)
                                      );
                }catch (InvalidCredentialsException $th) {
                   return  Response::error(false,$th->getMessage(),401);
                }

                break;
            default:
                echo "Ruta GET no encontrada: '$router->url'";
        }
        break;
        default:
          echo "Método HTTP no soportado '$router->url'";

        break;

    case 'DELETE':
        switch ($router->url) {
            case 'usersDeleteById':
                $controller->delete($router->queryParams['id']);
                break;
            default:
                echo "Ruta GET no encontrada: '$router->url'";
        }
        break;

}