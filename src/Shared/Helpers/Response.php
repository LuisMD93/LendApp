<?php

namespace Shared\Helpers;

class Response{

    static function sendResponse(array|object $data, $status = 200) {
        //header('Content-Type: application/json; charset=utf-8');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    static function jsonEncode($data, $status = 200) {
        return json_encode($data);
    }

   static function arrayParse($request) : array {
        
        $data = json_decode(file_get_contents($request), true); // Obtener datos JSON del cuerpo de la solicitud
        //Response::If_startDate_Is_Empty($data);// si trabajas con fechas y  quieres ajustarlo a la fecha local
        //       echo json_encode([
        //             "origin" => "Response",
        //             "status" => "ok",
        //             "location" => $data["location"] ,
        //             "cantidad" => $data["amount"] ,
        //             "descripcion" => $data["description"] ,
        //             "estado prestamo" => $data["lendStatus"] ,
        //             "nombre producto" => $data["name"]
        //         ]);
        //  echo "---------------------------------------------------------";
        return $data;
    }



    public static function success(bool $response, string $message, int $status = 200 , $token = ''): void {
        self::sendResponse([
            "response" => $response,
            "Data"     => strlen($token)>16 ? ["token"=>$token] : null,
            "message"  => $message,
            "status"   => $status
        ], $status);
    }

    public static function error($response,string $message, int $status = 400): void {
        self::sendResponse([
            "response" => $response,
            "Data"     => null,
            "message"  => $message,
            "status"   => $status
            ], $status);
    }

}