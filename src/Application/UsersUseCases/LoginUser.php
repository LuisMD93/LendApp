<?php

namespace Application\UsersUseCases;

use Application\DTOs\UserDto;
use Domain\Repository\IUserRepository;
use Application\Mappers\UserMapper;
use Application\Exceptions\InvalidCredentialsException;


class LoginUser {

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function execute(string $user,string $phone): UserDto {
     
       $user = $this->userRepository->login($user,$phone);
       if(!$user){
          throw new InvalidCredentialsException();
       }
      
       $userEntity = UserMapper::fromArrayEntitySingle($user);
       return UserMapper::toDto($userEntity);    
       
    }
}