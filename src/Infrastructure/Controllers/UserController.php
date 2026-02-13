<?php

namespace Infrastructure\Controllers;

use Application\DTOs\UserDto;
use Application\DTOs\LoginRequestDto;
use Application\Exceptions\InvalidCredentialsException;
use Application\UsersUseCases\AddUsers;
use Application\UsersUseCases\ListUsers;
use Application\UsersUseCases\SearchByPhoneUser;
use Application\UsersUseCases\DeleteUser;
use Application\UsersUseCases\LoginUser;
use Application\UsersUseCases\UpdateUser;
use Shared\Helpers\Response;
use Shared\Mapping\UserMapper;
use Shared\Helpers\Constants\Constans;
use Shared\Helpers\Validations\UserValidation;
use Infrastructure\Firebase\JWT;

class UserController{


    private $searchByPhoneUser;
    private $addUsers;
    private $updateUser;
    private $deleteUser;
    private $listUsers;
    private $login_access;

    // Inyección de dependencia por constructor
    public function __construct(AddUsers $addUsers, ListUsers $listUsers,SearchByPhoneUser $searchByPhoneUser,DeleteUser $deleteUser ,UpdateUser $updateUser,LoginUser $login_access) {
        $this->addUsers = $addUsers;
        $this->searchByPhoneUser = $searchByPhoneUser;
        $this->updateUser = $updateUser;
        $this->deleteUser = $deleteUser;
        $this->listUsers = $listUsers;
        $this->login_access = $login_access;
    }


    function save(UserDto $userDto) {
        
        $data = UserValidation::validateRequiredFields(UserMapper::toArray($userDto),Constans::FIELDS);
       
        if (!empty($data)) {
            return Response::sendResponse($data, 422);
        }
 
        $response = $this->addUsers->execute($userDto);

        if ($response) {
            return Response::success($response, "Data added to the system");
        }
        return Response::error($response,"There is already an email address or phone number in the system",409);
    }

    function show() {
        Response::sendResponse($this->listUsers->execute());     
    }


    // function getAuth(string $name, string $pass) {
    //     Response::sendResponse($this->listUserAndRole->execute($name,$pass));     
    // }

    function getByPhone(string $phone) {  

        $result = $this->searchByPhoneUser->execute($phone);
        if($result){
          return Response::success($result,"number registered in the system");
        }
          return Response::error($result,"number not registered in the system",409);

    }

    function update(UserDto $user){
    
        $result = UserValidation::validateRequiredFields(UserMapper::toArray($user),Constans::FIELDS);
       
        if (!empty($result)) {
            return Response::sendResponse($result, 422);
        }
 
        $response = $this->updateUser->execute($user);

        if ($response) {
            return Response::success($response, "data updated correctly");
        }
        return Response::error($response,"User not updated from the system, verify the ID -> ".$user->getId(),409);
  
    }

    function delete(int $id){

       $result = $this->deleteUser->execute($id);
       if($result){
          return Response::success($result,"User with ID ".$id." deleted from the system.");
       }
          return Response::error($result,"User not deleted from the system, verify the ID -> ".$id,409);
    }

    // function access(LoginRequestDto $loginRequestDto){

    //     try {
    //          $result = $this->login_access->execute($loginRequestDto->username,$loginRequestDto->password);
    //          $payload = Jwt::createPayload($result->getUsername(),$result-> getRoleEnum()->value);
    //          return Response::success($payload,"Ok",200);
    //     } catch (InvalidCredentialsException $th) {
    //          return  Response::error(false,$th->getMessage(),401);
    //     }
      
    // }
    function access(){

        try {
             //$result = $this->login_access->execute($loginRequestDto->username,$loginRequestDto->password);
             //$payload = Jwt::createPayload($result->getUsername(),$result-> getRoleEnum()->value);
             return Response::success('xx',"Ok",200);
        } catch (InvalidCredentialsException $th) {
             return  Response::error(false,$th->getMessage(),401);
        }
      
    }


}