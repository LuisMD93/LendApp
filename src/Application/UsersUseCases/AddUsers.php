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

            $response = $this->userRepository->existsUser($userDto->getEmail(),$userDto->getPhone());
            if ($response==false){
               echo '<pre>';print_r(["response"=>"No existe en bd"]);echo '</pre>';
                           $userEntity = UserMapper::toEntity($userDto);
                            echo '<pre>';print_r(["Entidad"=>$userEntity]);echo '</pre>';
                           $response = $this->userRepository->createUser($userEntity);
                            echo '<pre>';print_r(["respuesta"=>$response]);echo '</pre>';

               return $response;
            }else{
                echo '<pre>';print_r(["response"=>"Existe en bd" ,"Email"=>$userDto->getEmail(),"Phone"=>$userDto->getPhone()]);echo '</pre>';die;
            }
            
            // if(!$this->userRepository->existsUser($userDto->getEmail(),$userDto->getPhone())){
            //    return false;
            // }
            $userEntity = UserMapper::toEntity($userDto);
            $response = $this->userRepository->createUser($userEntity);
            return $response;  
        
    }
}