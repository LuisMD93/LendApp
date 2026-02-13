<?php

namespace Application\UsersUseCases;

use Domain\Repository\IUserRepository;
use Application\DTOs\UserDto;

class SearchByPhoneUser{

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $phone): bool {
            
        $response = $this->userRepository->searchUserByPhone($phone);
        return $response;  
        
    }
}