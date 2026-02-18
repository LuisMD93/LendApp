<?php

namespace Application\UsersUseCases;

use Application\DTOs\UserDto;
use Domain\Repository\IUserRepository;
use Application\Mappers\UserMapper;
use Application\Exceptions\InvalidCredentialsException;
use Application\Exceptions\EmptyCredentialsException;


class LoginUser {

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function execute(string $user,string $phone): UserDto {
     
       if ($user==='' || $phone==='') {
           throw new EmptyCredentialsException();
       }
       $user = $this->userRepository->login($user,$phone);
       if(!$user){
          throw new InvalidCredentialsException();
       }
      
       $userEntity = UserMapper::fromArrayEntitySingle($user);
       return UserMapper::toDto($userEntity);    
       
    }
}