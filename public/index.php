<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Classes\User;
use App\Classes\Book;
use App\Controllers\UserController;
use App\Controllers\BookController;

session_start();

$slug = isset($_GET["slug"]) ? $_GET["slug"] : "/";

/* $user = new User("Jhon", "jhon@test.com", "123123123");
$book = new Book(17, "El mundo de sofía", "Downloads\Anderson Triana CV E.pdf");

$bookController = new BookController(); */
$userController = new UserController();

$userValidation = $userController->validate_login("jhon@test.com", "123123123");

if ($userValidation["status"]) {
    $user = $userValidation["user"];
    $_SESSION["user_id"] = $user->get_id();
    $_SESSION["username"] = $user->get_username();
    $_SESSION["email"] = $user->get_email();
}

#var_dump($userController->store($user));
#var_dump($bookController->store($book));

#var_dump($userController->show(1));

#var_dump($_GET["slug"]);