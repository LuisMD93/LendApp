<?php

namespace Domain\Models;
use Shared\Helpers\Enums\RoleEnum;

use DateTime;

class User {

    private int $id;
    private string $username;
    private string $email;
    private string $password; 
    private string $api_token;
    private string $phone;
    
    private RoleEnum $role;
    private DateTime $creationDate;
    private DateTime $modificationDate;

     // Constructor
    public function __construct(
        int $id,
        string $username = 'to be defined',
        string $email = 'to be defined',
        string $password = '',
        string $api_token = 'to be defined',
        string $phone = "xxxxxxxxxxx",
        RoleEnum $role = RoleEnum::UNDEFINED,
        DateTime $creationDate = new DateTime('0000-00-00 00:00:00'),
        DateTime $modificationDate = new DateTime('0000-00-00 00:00:00')
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->api_token = $api_token;
        $this->phone =$phone;

        $this->role = $role;
        $this->creationDate = $creationDate;
        $this->modificationDate = $modificationDate;
    }


    /* =======================
       Getters y Setters 
       ======================= */

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }


    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }


    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }


    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }


    public function getApiToken(): string {
        return $this->api_token;
    }

    public function setApiToken(string $api_token): void {
        $this->api_token = $api_token;
    }


    public function getPhone(): string {
        return $this->phone;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }


    /* ===========================================
       Getters y Setters de atributos comentados
       (también comentados)
       =========================================== */

    
    public function getRoleEnum(): RoleEnum {
        return $this->role;
    }

    public function setRoleEnum(RoleEnum $role): void {
        $this->role = $role;
    }
    

    
    public function getCreationDate(): DateTime {
        return $this->creationDate;
    }

    public function setCreationDate(DateTime $creationDate): void {
        $this->creationDate = $creationDate;
    }
    

    
    public function getModificationDate(): DateTime {
        return $this->modificationDate;
    }

    public function setModificationDate(DateTime $modificationDate): void {
        $this->modificationDate = $modificationDate;
    }
    

}
