<?php

namespace Database;

use PDO;
use PDOException;

class DatabaseConnection {

    private static $instance;
    private $connection;

    private function __construct($server, $database, $username, $password) {
        $this->makeDatabaseConnection($server, $database, $username, $password);
    }

    public static function getInstance($server, $database, $username, $password) {
        if (!self::$instance instanceof self) {
            self::$instance = new self($server, $database, $username, $password);
        }

        return self::$instance;
    }

    public function getDatabaseConnection() {
        return $this->connection;
    }

    private function makeDatabaseConnection($server, $database, $username, $password) {
        try {
            $mysql = new PDO("mysql:host={$server};dbname={$database}", $username, $password);
        } catch (PDOException $e) {
            die("Falló la conexión a la base de datos: {$e->getMessage()}");
        }

        $this->connection = $mysql;
    }
}