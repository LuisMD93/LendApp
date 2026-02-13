<?php

namespace Application\UsersUseCases;

use Application\DTOs\UserDto;
use Domain\Repository\IUserRepository;
use Application\Mappers\UserMapper;

class ListUsers {

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): array {
        
            $user = $this->userRepository->getAllUsers();
            $dataEntity = UserMapper::fromArrayEntity($user);
            $dataDto = UserMapper::fromArrayDto($dataEntity);
            return $dataDto;
        
    }
}