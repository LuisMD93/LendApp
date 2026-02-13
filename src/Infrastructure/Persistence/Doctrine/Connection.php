<?php

namespace Infrastructure\Persistence\Doctrine;

class Connection {
    
    private $connection;   
    private static $instance = null;

    public function __construct()
    {
        $config = require __DIR__ . '/../../../../config/config.php'; 
        $database = $config['database'];
       
 
        $dsn = "mysql:host={$database['host']};dbname={$database['dbname']};charset={$database['charset']}";

        try {
            $this->connection = new \PDO($dsn, $database['user'], $database['password']);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage().' '.$database['password']);
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
