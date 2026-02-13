<?php

namespace Application\Exceptions;

use Exception;

class InvalidCredentialsException  extends Exception
{
    public function __construct(string $message = "Credenciales inválidas", int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
