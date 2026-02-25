<?php

namespace Infrastructure\Exceptions;
use Exception;

class DataAccessException extends Exception {

    public function __construct(string $message, int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
 #= "Error alejecutar proceso en base de datos"