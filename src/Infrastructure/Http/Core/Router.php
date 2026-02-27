<?php

namespace Infrastructure\Http\Core;

class Router {

    public string $method;
    public string $url;
    private array $queryParams;
    private array $headers;

    function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->queryParams = $_GET;

        $url = $_SERVER['REQUEST_URI'];
        $url = parse_url($url, PHP_URL_PATH);

        $scriptName = dirname($_SERVER['SCRIPT_NAME']);

        // CORRECCIÓN: Solo hacemos el reemplazo si el scriptName NO es solo una barra
        // y si realmente está presente al inicio de la URL.
        if ($scriptName !== '/' && $scriptName !== '\\' && !empty($scriptName)) {
            $url = str_replace($scriptName, '', $url);
        }
        $tokenRaw = $_SERVER['HTTP_AUTHORIZATION']      // 1. Caso estándar (con .htaccess)
        ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] // 2. Caso de redirección
        ?? $this->headers['Authorization']        // 3. Caso directo (Nginx)
        ?? $this->headers['authorization']        // 4. Caso en minúsculas
        ?? null;
        $this->url = trim($url, '/');
        $this->headers = ["userName"=>$_SERVER['PHP_AUTH_USER']  ?? null,"userPassword"=>$_SERVER['PHP_AUTH_PW'] ?? null,"param"=>$this->queryParams,"token"=>$tokenRaw];
    }


    public function getHeaders() : array{
        return $this->headers;
    }
}