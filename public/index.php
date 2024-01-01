<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Classes\User;
use App\Classes\Book;
use App\Classes\Router;
use App\Controllers\UserController;
use App\Controllers\BookController;

session_start();


$userController = new UserController();
$userValidation = $userController->validate_login("jhon@test.com", "123123123");

charge_routes();

$slug = isset($_GET["slug"]) ? $_GET["slug"] : "";
$method = $_SERVER["REQUEST_METHOD"];
$router = Router::get_instance();

dd($router->route($method, $slug));