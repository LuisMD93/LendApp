<?php

namespace Application\DTOs;

use DateTime;
use Shared\Helpers\Enums\RoleEnum;
use JsonSerializable;

class UserDto implements JsonSerializable {

    public int $id;
    public string $username;
    public string $email;
    public string $password; // Agregamos el campo password
    public string $api_token;
    public string $phone;
    private RoleEnum $role;
    public DateTime $creationDate;
    public DateTime $modificationDate;
    

    // Constructor
    public function __construct(
        int $id,
        string $username = 'to be defined',
        string $email = 'to be defined',
        string $password = '', // Se agrega el parámetro password al constructor
        string $api_token = 'to be defined',
        string $phone = "xxxxxxxxxxx",
        RoleEnum $role = RoleEnum::UNDEFINED,
        DateTime $creationDate = new DateTime('0000-00-00 00:00:00'),
        DateTime $modificationDate = new DateTime('0000-00-00 00:00:00')
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password; // Se asigna la contraseña
        $this->api_token = $api_token;
        $this->phone =$phone;

        $this->role = $role;
        $this->creationDate = $creationDate;
        $this->modificationDate = $modificationDate;
    }

 

    // Getters

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password; // Getter para la contraseña
    }

    public function getWebToken(): string {
        return $this->api_token;
    }
    
    public function getPhone(): string {
        return $this->phone;
    }

    public function setPhone(string $phone) {
         $this->phone = $phone; 
    }

    public function getRoleEnum(): RoleEnum {
        return $this->role;
    }

    public function getCreationDate(): DateTime {
        return $this->creationDate;
    }

    public function getModificationDate(): DateTime {
        return $this->modificationDate;
    }

    // Setters

    public function setId(int $id): void {

        $this->id = $id;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password; // Setter para la contraseña
    }

    public function setWebToken(string $api_token): void {
        $this->api_token = $api_token;
    }

    public function setRoleEnum(RoleEnum $role): void {
        $this->role = $role;
    }

    public function setCreationDate(DateTime $creationDate): void {
        $this->creationDate = $creationDate;
    }

    public function setModificationDate(DateTime $modificationDate): void {
        $this->modificationDate = $modificationDate;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,  // Se agrega el campo password a la serialización
            'api_token' => $this->api_token,
            'phone' => $this->phone,
             'role_user' => $this->role,
            'creation_date' => $this->creationDate->format('Y-m-d H:i:s'),
            'modification_date' => $this->modificationDate->format('Y-m-d H:i:s'),
        ];
    }
}
