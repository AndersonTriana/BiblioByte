<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Database\DatabaseConnection;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// DB connection
$dbConnection = DatabaseConnection::getInstance($_ENV["SERVER"], $_ENV["DATABASE"], $_ENV["USERNAME"], $_ENV["PASSWORD"]);
$pdo = $dbConnection->getDatabaseConnection();

echo "<h1>index</h1>";

var_dump($pdo);
