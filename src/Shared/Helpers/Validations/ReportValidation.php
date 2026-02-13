<?php

namespace Shared\Helpers\Validations;

use DateTime;
use Shared\Helpers\Enums\TypeTimeEnum;

class ReportValidation {


    public static function validateRequiredFields(array $data, array $fields){
       
        $errors = [];
        
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === ''|| $data[$field] === 0){
               
                $errors[] = [
                    "error" => "El campo {$field} no puede estar vacío.",
                    'message' => 'error!! Reporte No agregado',
                    'details' =>'Asegurate de llenar todos los campos...'
                ];
           }
        }
        return $errors;
    }


   private static function validateDatetime($datetime) {
        $format = 'Y-m-d H:i:s'; // formato esperado
        $d = DateTime::createFromFormat($format, $datetime);
        return $d && $d->format($format) === $datetime;
    }

    public static function Validar_id($requestParamId) {
            // Verifica si la cadena contiene solo dígitos
            if (preg_match('/^[0-9]+$/', $requestParamId)) {
                return true; // La ID es válida
            } else {
                return false; // La ID contiene caracteres no permitidos
            }
        
    }

    public static function getTypeTimeEnumValue($typeTime) {
        
        switch ($typeTime) {
            case 'HOURS':
                return      TypeTimeEnum::HOURS;
            case 'DAYS':
                return      TypeTimeEnum::DAYS;
            case 'MONTHS':
                return      TypeTimeEnum::MONTHS;
            case 'YEARS':
                return      TypeTimeEnum::YEARS;
            default:
                throw new \InvalidArgumentException("El tipo de tiempo '$typeTime' no es válido.");
        }
    }

    
}