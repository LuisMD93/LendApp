<?php

namespace Application\Mappers;

use Application\Dtos\UserDto;
use Domain\Models\User;
use DateTime;
use Shared\Helpers\Enums\RoleEnum;

class UserMapper {

    public static function toEntity(UserDto $dto): User {
        return new User(
            $dto->id,
            $dto->username,
            $dto->email,
            $dto->password,
            $dto->api_token,
            $dto->phone,
            $dto->getRoleEnum(),
            $dto->creationDate,
            $dto->modificationDate
        );
    }

    public static function toDto(User $entity): UserDto {
      
        return new UserDto(
            $entity->getId(),
            $entity->getUsername(),
            $entity->getEmail(),
            $entity->getPassword(),
            $entity->getApiToken(),
            $entity->getPhone(),
            $entity->getRoleEnum(),
            $entity->getCreationDate(),
            $entity->getModificationDate()
        );
    }

    public static function fromArrayEntity(array $users) {
        $userArray = [];
        foreach ($users as $user) {
        $rolEnum = RoleEnum::tryFrom($user['rol_user']) ?? RoleEnum::UNDEFINED;
          $userArray[] =  new User(
        
                $user['id'],  
                $user['username'],
                $user['email'],
                $user['password'],
                $user['api_token'],
                $user['phone'],
                $rolEnum,
                new DateTime($user['creationdate']), 
                new DateTime($user['modificationdate'])
            );
        }
        return $userArray;
    }

     public static function fromArrayEntitySingle(array $user) {
          $rolEnum = RoleEnum::tryFrom($user['rol_user']) ?? RoleEnum::UNDEFINED;
          return  new User(
                $user['id'],  
                $user['username'],
                $user['email'],
                $user['password'],
                $user['api_token'],
                $user['phone'],
                $rolEnum,
                new DateTime($user['creationdate']), 
                new DateTime($user['modificationdate'])
            );
    }

    public static function fromArrayDto(array $users): array {
        
        $userArrayDto = [];
        foreach ($users as $userDto) {
        
          $userArrayDto[] =  new UserDto(
                $userDto->getId(),
                $userDto->getUsername(),
                $userDto->getEmail(),
                $userDto->getPassword(),
                $userDto->getApiToken(),
                $userDto->getPhone(),
                $userDto->getRoleEnum(),
                $userDto->getCreationDate(),
                $userDto->getModificationDate()        
            );
          
        }
        return $userArrayDto; 
    }
}
