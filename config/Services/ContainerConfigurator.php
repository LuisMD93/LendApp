<?php

namespace config\Services;


use Config\Container;
use Infrastructure\Persistence\Doctrine\Connection;
use Infrastructure\Persistence\Repository\UsersRepository; 
use Infrastructure\Persistence\Repository\ReportRepository; 
use Domain\Repository\IUserRepository;
use Domain\Repository\IReportRepository;
use Infrastructure\Middlewares\AuthMiddleware;
use Application\UsersUseCases\LoginUser;

// $container = new Container();

// // Conexión a BD
// $container->set(Connection::class, function () {
//     return new Connection();
// });

// // Repositorio - interfaz → implementación
// $container->set(IUserRepository::class, function($c) {
//     return new UsersRepository(
//         $c->get(Connection::class)
//     );
// });

// return $container;
// <?php
// namespace Config;

// use Infrastructure\Database\Connection;
// use Infrastructure\Repository\UsersRepository;
// use Domain\Repository\IUserRepository;

class ContainerConfigurator
{
    public static function configure(Container $container): Container
    {
        // Registrar servicios aquí
        $container->set(Connection::class, function () {
            return new Connection();
        });

        $container->set(IUserRepository::class, function ($c) {
            return new UsersRepository(
                $c->get(Connection::class)
            );
        });

        $container->set(IReportRepository::class, function ($c) {
            return new ReportRepository($c->get(Connection::class));
        });

        $container->set(AuthMiddleware::class, fn($c) => new AuthMiddleware($c->get(LoginUser::class)));

        return $container;
    }
}
