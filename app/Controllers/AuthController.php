<?php

namespace App\Controllers;

use App\Controllers\UserController;
use Database\DatabaseConnection;

class AuthController {
    public function index() {
        $user_id = $_SESSION["user_id"] ?? false;
        if (!$user_id) {
            return require('../views/Auth/Login.php');
        }

        header("Location: /home");
        exit();
    }

    public function login(string $email, string $password) {
        $userController = new UserController();
        $user = $userController->get_user_by_email($email);

        if (!$user) {
            $error = [
                "message" => "The email is not connected to an account",
                "input" => "email"
            ];

            return require('../views/Auth/Login.php');
        }

        if (!password_verify($password, $user->get_password())) {
            $error = [
                "message" => "Incorrect password",
                "input" => "password"
            ];

            return require('../views/Auth/Login.php');
        }

        $_SESSION["user_id"] = $user->get_id();
        $_SESSION["username"] = $user->get_username();

        header("Location: /home");
        exit();
    }

    public function logout() {
        session_destroy();

        header("Location: /");
        exit();
    }
}
