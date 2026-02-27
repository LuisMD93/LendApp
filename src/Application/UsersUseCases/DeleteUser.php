<?php

namespace Application\UsersUseCases;

use Domain\Repository\IUserRepository;

class DeleteUser {

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(int $id): bool {
            
            $response = $this->userRepository->deleteUserById($id);
            return $response;  
        
    }
}