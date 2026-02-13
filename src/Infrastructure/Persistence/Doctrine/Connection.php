<?php

// namespace Infrastructure\Persistence\Doctrine;

// class Connection {
    
//     private $connection;   
//     private static $instance = null;

//     public function __construct()
//     {
//         $config = require __DIR__ . '/../../../../config/config.php'; 
//         $database = $config['database'];
       
 
//         $dsn = "mysql:host={$database['host']};dbname={$database['dbname']};charset={$database['charset']}";

//         try {
//             $this->connection = new \PDO($dsn, $database['user'], $database['password']);
//             $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

//         } catch (\PDOException $e) {
//             die("Connection failed: " . $e->getMessage().' '.$database['password']);
//         }
//     }

//     public static function getInstance() {
//         if (self::$instance === null) {
//             self::$instance = new Connection();
//         }
//         return self::$instance;
//     }

//     public function getConnection() {
//         return $this->connection;
//     }

//     private function __clone() {}
//     public function __wakeup() {}
// } -->



namespace Infrastructure\Persistence\Doctrine;

class Connection {
    
    private $connection;   
    private static $instance = null;

    public function __construct()
    {
        // Intentamos leer de las variables de entorno (Render)
        // Si no existen, intentamos cargar el archivo config.php (Local)
        $configPath = __DIR__ . '/../../../../config/config.php';
        $config = file_exists($configPath) ? require $configPath : [];

        // Prioridad: Variable de entorno > Archivo config > Valor por defecto
        $host = getenv('DB_HOST') ?: ($config['database']['host'] ?? 'localhost');
        $db   = getenv('DB_NAME') ?: ($config['database']['dbname'] ?? '');
        $user = getenv('DB_USER') ?: ($config['database']['user'] ?? '');
        $pass = getenv('DB_PASS') ?: ($config['database']['password'] ?? '');
        $port = getenv('DB_PORT') ?: ($config['database']['port'] ?? '5432');

        // IMPORTANTE: Cambiamos mysql por pgsql y ajustamos el DSN
        $dsn = "pgsql:host=$host;port=$port;dbname=$db";

        try {
            $this->connection = new \PDO($dsn, $user, $pass);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            // No imprimas el password en el die por seguridad, mejor usa el log
            error_log("Error de conexión: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    private function __clone() {}
    public function __wakeup() {}
}
