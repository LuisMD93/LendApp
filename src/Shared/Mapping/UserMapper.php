<?php

namespace Shared\Mapping;

use Application\Dtos\LoginRequestDto;
use Application\Dtos\UserDto;

use DateTime;

class UserMapper {

    public static function toArray(UserDto $user) {
        return [
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'api_token' => $user->getWebToken(),
                'phon' => $user->getPhone()
        ];
    }

    
    public static function fromArray(array $data) {
        return new UserDto(
                $data["id"] ?? 0,
                $data["Username"],
                $data["Email"],    
                $data["Password"],    
                $data["API_Token"], 
                $data["Phone"],
                $data["role_user"],
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





