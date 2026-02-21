<?php

namespace Shared\Mapping;

use Application\Dtos\LoginRequestDto;
use Application\Dtos\UserDto;
use Shared\Helpers\Enums;

use DateTime;
use Shared\Helpers\Enums\RoleEnum;

class UserMapper {

    public static function toArray(UserDto $user) {
        return [
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'api_token' => $user->getWebToken(),
                'phone' => $user->getPhone(),
                'rol_user' => $user->getRoleEnum()->value
        ];
    }

    
    public static function fromArray(array $data) {
        return new UserDto(
                $data["id"] ?? 0,
                $data["username"],
                $data["email"],    
                $data["password"],    
                $data["api_token"], 
                $data["phone"],
                RoleEnum::from($data["role_user"]),
                new DateTime(),
                new DateTime()       
        );
    }

    public static function fromArraylogin(array $data) {
        return new LoginRequestDto(
                $data["userName"],
                $data["userPassword"],
        );
    }

   
}





