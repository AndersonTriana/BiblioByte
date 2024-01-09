<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Classes\User;
use App\Classes\Book;
use App\Classes\Router;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\BookController;

session_start();

$auth = new AuthController();

charge_routes();

$slug = isset($_GET["slug"]) ? $_GET["slug"] : "";
$method = $_SERVER["REQUEST_METHOD"];
$router = Router::get_instance();

$params = $_POST ?? null;
$router->route($method, $slug, $params);

dd($_SESSION);