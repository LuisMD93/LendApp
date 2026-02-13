<?php

namespace Application\DTOs;

class LoginRequestDto
{
    public function __construct(
        public string $username,
        public string $password
    ) {}
}