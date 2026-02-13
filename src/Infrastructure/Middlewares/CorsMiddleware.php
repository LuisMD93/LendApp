<?php

namespace Infrastructure\Middlewares;

class CorsMiddleware {
    
    public function handle(): void {

        $allowedOrigins = [
            'http://localhost:3000',
            'http://127.0.0.1:3000',
            'http://127.0.0.1:5501'
        ];

        $origin = $_SERVER['HTTP_ORIGIN'] ?? null;

        if ($origin && in_array($origin, $allowedOrigins)) {
            header("Access-Control-Allow-Origin: $origin");
            header("Access-Control-Allow-Credentials: true");
        }
        //header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }
}
