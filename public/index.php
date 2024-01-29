<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Classes\Router;
use App\Controllers\AuthController;

session_start();

$auth = new AuthController();

charge_routes();

$slug = htmlspecialchars(isset($_GET["slug"]) ? $_GET["slug"] : "");
$method = $_SERVER["REQUEST_METHOD"];
$router = Router::get_instance();

$params = $_POST ?? null;

if ($_FILES) {
    $params = array_merge($_FILES, $params);
}

$router->route($method, $slug, $params);

dd($_SESSION);
