<?php

namespace Application\UsersUseCases;

use Application\DTOs\UserDto;
use Domain\Repository\IUserRepository;
use Application\Mappers\UserMapper;

class AddUsers {

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserDto $userDto): bool {
            
            echo '<pre>';print_r($this->userRepository->existsUser($userDto->getEmail(),$userDto->getPhone()));echo '</pre>';die;
            if($this->userRepository->existsUser($userDto->getEmail(),$userDto->getPhone())){
               return false;
            }
            $userEntity = UserMapper::toEntity($userDto);
            $response = $this->userRepository->createUser($userEntity);
            return $response;  
        
    }
}