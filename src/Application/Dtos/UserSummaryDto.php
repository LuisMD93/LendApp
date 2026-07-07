<?php

namespace Application\Dtos;


class UserSummaryDto {

    public int $id;
    public string $username;

    public function __construct(int $id, string $username = 'to be defined') {
        $this->id = $id;
        $this->username = $username;      
    }


    // Getters

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    // Setters

    public function setId(int $id): void {

        $this->id = $id;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

}