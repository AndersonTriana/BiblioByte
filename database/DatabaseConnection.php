<?php

namespace Database;

#use Dotenv\Dotenv;
use PDO;
use PDOException;

class DatabaseConnection {

    private static $instance;
    private $connection;

    private function __construct() {
        $this->make_database_connection();
    }

    public static function get_instance(): self {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get_database_connection(): PDO {
        return $this->connection;
    }

    private function make_database_connection(): void {
        /* $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $server   = $_ENV["SERVER"];
        $database = $_ENV["DATABASE"];
        $username = $_ENV["USERNAME"];
        $password = $_ENV["PASSWORD"];
        */
        $server   = "localhost";
        $database = "bibliobyte";
        $username = "root";
        $password = "123123123";

        try {
            $mysql = new PDO("mysql:host={$server};dbname={$database}", $username, $password);
        } catch (PDOException $e) {
            die("Falló la conexión a la base de datos: {$e->getMessage()}");
        }

        $this->connection = $mysql;
    }
}