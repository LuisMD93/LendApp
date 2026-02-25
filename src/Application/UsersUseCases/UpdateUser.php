<?php

namespace Application\UsersUseCases;

use Application\DTOs\UserDto;
use Domain\Repository\IUserRepository;
use Application\Mappers\UserMapper;

class UpdateUser {

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserDto $userDto): bool {
            echo '<pre>';print_r(is_bool($this->userRepository->findUserById($userDto->getId())));echo '</pre>';die;
            if($this->userRepository->findUserById($userDto->getId())){
                $userEntity = UserMapper::toEntity($userDto);
                $response = $this->userRepository->updateUser($userEntity);
                return $response;
            }
           
            return false;  
        
    }
}