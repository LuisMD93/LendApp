<?php

namespace Infrastructure\Middlewares;
use Application\UsersUseCases\LoginUser;
use Shared\Helpers\Response;
use Shared\Helpers\Constants\Constans;
use Infrastructure\Firebase\Jwt;


class AuthMiddleware {

    private  $caseLoginUser;
   

    // Constructor donde inyectamos la dependencia
    public function __construct(LoginUser $caseLoginUser) {

        $this->caseLoginUser = $caseLoginUser;
        if ($caseLoginUser === null) {
            throw new \Exception("La dependencia no ha sido inyectada correctamente.");
        }
    }

    private  function isAuthorization($request) : bool {
        return isset($request['Authorization']);
    }

    private function isBasic($authHeader) : bool {
        return strpos($authHeader, 'Basic ') === 0;
    }

    private function extractBasicAuthCredentials($authHeader) : array {

        $encodedCredentials = substr($authHeader, 6);
        $decoded = base64_decode($encodedCredentials);

        if (!$decoded || !str_contains($decoded, ':')) {
            return [];
        }

        list($user, $password) = explode(':', $decoded, 2); 

        return [
                 "userName"=>$user,
                 "userPassword"=>$password
               ];

    }
    
    public function authMiddleware($request): string {
     
        if (!$this->isAuthorization($request)) {
            return Constans::UNAUTHORIZED_MESSAGE;
        }
        
            $authHeader = $request['Authorization'];
    
        if(!$this->isBasic($authHeader)) {
            return Constans::UNAUTHORIZED_MESSAGE;
        }

        $dataUsers = $this->extractBasicAuthCredentials($authHeader);
        $dataCrendentils=$this->caseLoginUser->execute($dataUsers["userName"],$dataUsers["userPassword"]);
        $header = Jwt::createHeader();
        $secretKey = self::getSecretKey();
        $payload = Jwt::createPayload($dataCrendentils->getUsername(),$dataCrendentils->getRoleEnum()->value,$dataCrendentils->getId());
        $jwt = Jwt::createJwt($payload, $secretKey,$header);

        return $jwt;
    }


            
    private static function getSecretKey(): string {

       $configPath = __DIR__ . '.../../../../config/config.php';
       $config = include $configPath;
   
       return $config['secretKey'] ?? 'default_secret';
    }


    public  function checkAdmin($request) : bool {

   
            if (!$this->isAuthorization($request)) {
                return false;
            }

            $authHeader = $request['Authorization'];
            if (strpos($authHeader, 'Bearer') !== 0) {
                return false;
            }

            $Jwt = Jwt::RemoveBearer($authHeader);
            if (empty($Jwt)) {
                return false;
            }

            $dataCrendentils = Jwt::ExtractInfoFromToken($Jwt, 1);
            if (strtolower($dataCrendentils["rol"]) == 'admin') {
                return true;
            }
        
        return false;
    }

    public function isValidJwt($request) : bool{

        if (!$this->isAuthorization($request)) {
            return Constans::UNAUTHORIZED_MESSAGE;
        }

        $authHeader = $request['Authorization'];
        if (strpos($authHeader, 'Bearer') !== 0) {
            return false;
        }
       
         $Jwt = Jwt::RemoveBearer($authHeader);
           if (empty($Jwt)) {
            return false;
           }
        
         $parts = explode('.', $Jwt);
            if (count($parts) !== 3) {
                return false;
            }

        list($headerB64, $payloadB64, $signatureB64) = $parts;
         // Recalcular la firma con el header + payload y la clave secreta
         $data = "$headerB64.$payloadB64";
         
         $secretKey = self::getSecretKey();
         $expectedSignature = Jwt::base64UrlEncode(hash_hmac('sha256', $data, $secretKey, true));
        //  // Comparar firma esperada con la firma enviada
         return hash_equals($expectedSignature, $signatureB64);
         
    }
        
      
    public function ValidateTokenExpiration($request) : bool {
    
      date_default_timezone_set('America/Bogota');

            if (!$this->isAuthorization($request)) {
                return false;
            }

            $authHeader = $request['Authorization'];
            if (strpos($authHeader, 'Bearer') !== 0) {
                return false;
            }

            $Jwt = Jwt::RemoveBearer($authHeader);
            if (empty($Jwt)) {
                return false;
            }

            $dataPayload = Jwt::ExtractInfoFromToken($Jwt, 1);

            $iat = $dataPayload['iat']; // timestamp UNIX
            $currentTime = time();

            // ⏱️ 5 minutos = 300 segundos
            $expirationTime = $iat + 300;

            // Debug opcional
            // echo "Hora del token: " . date('Y-m-d H:i:s', $iat) . " ";
            // echo "Expira en: " . date('Y-m-d H:i:s', $expirationTime) . " ";
            // echo "Hora actual: " . date('Y-m-d H:i:s', $currentTime) . " ";

            return $currentTime <= $expirationTime;
    }

    
}
