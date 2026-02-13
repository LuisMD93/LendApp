<?php

namespace Infrastructure\Http\Core;

class Router {

    public string $method;
    public string $url;
    public array $queryParams;
    private array $headers;
    /*
    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->queryParams = $_GET; // Esto captura todos los query params


        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url)[0];
        $url = str_replace('/LendApp/public', '', $url);
        $url = preg_replace('#/+#', '/', $url);
        $this->url = trim($url, '/');
        $this->headers = getallheaders();
    }*/
    public function __construct() {
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->queryParams = $_GET;

            // 1. Obtenemos la URI completa (ej: /user o /LendApp/public/user)
            $url = $_SERVER['REQUEST_URI'];
            
            // 2. Quitamos los parámetros de consulta (?id=1...)
            $url = parse_url($url, PHP_URL_PATH);

            // 3. ESTA ES LA CLAVE: Eliminamos el path del script actual (index.php) 
            // de la URL. Esto quita automáticamente "/LendApp/public" en local 
            // y no quita nada en Render porque ahí no existe esa carpeta.
            $scriptName = dirname($_SERVER['SCRIPT_NAME']);
            $url = str_replace($scriptName, '', $url);

            // 4. Limpieza final: quitar slashes extras y dejarlo limpio
            $this->url = trim($url, '/');
            
            $this->headers = getallheaders();
    }


    public function getHeaders(): array {   
        return $this->headers;
    }
}
/**
 * class Router {

    public string $method;
    public string $url;
    public array $queryParams;
    private array $headers = [];

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->queryParams = $_GET;

        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url)[0];
        $url = preg_replace('#/+#', '/', $url);
        $this->url = trim($url, '/');

        $this->headers = $this->captureHeaders();
    }

    private function captureHeaders(): array {
        $headers = [];

        // Recorrer $_SERVER y normalizar
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = str_replace('_', '-', substr($key, 5));
                $headers[$name] = $value;
            }
        }

        // Authorization puede no estar en HTTP_...
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers['Authorization'] = $_SERVER['HTTP_AUTHORIZATION'];
        }
        if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        return $headers;
    }

    // Acceso a todos los headers
    public function getHeaders(): array {
        return $this->headers;
    }

    // Acceso a un header específico
    public function getHeader(string $name): ?string {
        return $this->headers[$name] ?? null;
    }

    // Authorization directamente
    public function getAuthorization(): ?string {
        return $this->getHeader('Authorization');
    }
}


 */