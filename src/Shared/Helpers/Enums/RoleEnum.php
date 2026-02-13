<?php

namespace Shared\Helpers\Enums;

enum RoleEnum: string {
    
    case ADMIN = 'ADMIN';
    case USER = 'USER';
    case STUDENT = 'STUDENT';
    case UNDEFINED = 'Undefined'; 

    public function description(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador con acceso completo',
            self::USER => 'Usuario con permisos limitados',
            self::STUDENT => 'Estudiante suscrito a x curso',
            self::UNDEFINED => 'En espera de un rol...',
        };
    }
}
