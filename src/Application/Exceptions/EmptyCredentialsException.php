<?php

namespace Application\Exceptions;
use Exception;

class EmptyCredentialsException extends Exception {

    public function __construct(string $message = "Las credendciales no pueden estar vacias inválidas", int $code = 401){
        parent::__construct($message, $code);
    }

}