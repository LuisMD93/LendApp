<?php

namespace Shared\Helpers\Validations;

class UserValidation {

    public static function validateRequiredFields(array $data, array $fields){
        
        $errors = [];
        
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === ''){
               
                $errors[] = [
                    "error" => "El campo {$field} no puede estar vacío.",
                    'message' => 'error!! usuario No agregado',
                    'details' =>'Asegurate de llenar todos los campos...'
                ];
           }
        }
        return $errors;
    }
 
}