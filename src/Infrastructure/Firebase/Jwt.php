<?php


namespace Infrastructure\Firebase;

use DateTime , DateTimeZone;
use Shared\Helpers\Response;
use Shared\Helpers\Constants\Constans;
use Application\UsersUseCases\LoginUser;

class JWT {
   
     private $login_access;

    // Constructor donde inyectamos la dependencia
    public function __construct(LoginUser $login_access) {
        $this->login_access = $login_access;
        if ($login_access === null) {
            throw new \Exception("La dependencia no ha sido inyectada correctamente.");
        }

    }


    // Función para codificar a Base64 URL
    public static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    // Función para decodificar Base64 URL
    private static function base64UrlDecode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    
    // Función para crear el JWT
    public static function createJWT($payload, $secretKey,$header) {

    

        // Codificar las partes en base64url
        $encodedHeader = self::base64UrlEncode(Response::jsonEncode($header));   // Codificar el header
        $encodedPayload = self::base64UrlEncode(Response::jsonEncode($payload)); // Codificar el payload

        // Crear la firma usando HMAC SHA256
        $signature = hash_hmac('sha256', "$encodedHeader.$encodedPayload", $secretKey, true);
        $encodedSignature = self::base64UrlEncode($signature); // Codificar la firma

        // Unir las tres partes (header, payload y signature) para formar el JWT
        $jwt = "$encodedHeader.$encodedPayload.$encodedSignature";

        return $jwt;


    }


    public static function  createHeader()  {
       // Header: Definir el tipo y algoritmo de firma
        $header =[
            'alg' => 'HS256', // Algoritmo de firma
            'typ' => 'JWT'
        ];
       
        return $header;
    }

    


    public static function  createPayload($username,$Rol,$id)  {

        $issuedAt = time();  // Fecha de emisión (actual)
        $expirationTime =  $issuedAt + 3600; // 3600 segundos = 1 hora
        
        $payload =[
            #'dni' => 1148242383, // Este es un dato personalizado (ejemplo)
            'dni'=>$id,
            'username' => $username,
            'rol' => $Rol,
            'iat' => $issuedAt,       // Fecha de emisión
            'exp' => $expirationTime, // Fecha de expiración
            'fecha' => (new DateTime('now', new DateTimeZone('America/Bogota')))->format('Y-m-d H:i:s') // Fecha en formato legible
        ];

        return $payload;
     }

    

    public static function RemoveBasic($credential) : string{
        $encodedCredentials = substr($credential, 6);
        return $encodedCredentials;
    }

    public static function RemoveBearer($credential) : string{
        $encodedCredentials = trim(str_ireplace('Bearer', '', $credential));
        return $encodedCredentials;
    }

    public static function ExtractInfoFromToken(string $jwt,int $position) : array {
        
        $parts = explode('.', $jwt);
        $data = $parts[$position];
        return  json_decode(base64_decode(strtr($data, '-_', '+/')), true);
    }


}