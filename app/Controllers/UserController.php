<?php

namespace App\Controllers;

use App\Classes\User;
use Database\DatabaseConnection;
use PDO;
use App\Controllers\AuthController;

class UserController {

    private $connection;

    public function __construct() {
        $this->connection = DatabaseConnection::get_instance()->get_database_connection();
    }

    /** Show the form for creating a new user */
    public function create() {
        $user_id = $_SESSION["user_id"] ?? false;
        if (!$user_id) {
            return require('../views/Auth/Register.php');
        }

        header("Location: /home");
        exit();
    }

    /** Store a newly created user in storage */
    public function store(string $username, string $email, string $password): array {
        $user = new User($username, $email, $password);

        $username = strtolower(trim($user->get_username()));

        if (preg_match("/[^a-zA-Z0-9]/", $username)) {

            $error = [
                "message" => "The username can't contain special characters",
                "input" => "username"
            ];

            return require('../views/Auth/Register.php');
        } else if (strlen($username) > 16) {
            $error = [
                "message" => "The username can't have more than 16 characters",
                "input" => "username"
            ];

            return require('../views/Auth/Register.php');
        }

        $email = strtolower(trim($user->get_email()));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = [
                "message" => "The email address is not valid",
                "input" => "email"
            ];

            return require('../views/Auth/Register.php');
        }

        $user_exists = $this->check_if_user_exists($user);

        if ($user_exists["status"]) {
            $error = $user_exists;

            return require('../views/Auth/Register.php');
        }

        // Store user
        $stmt = $this->connection->prepare(
            "INSERT INTO `users` (`username`, `email`, `password`) 
                VALUES (?, ?, ?)"
        );

        $response = $stmt->execute([
            $user->get_username(),
            $user->get_email(),
            password_hash($user->get_password(), PASSWORD_BCRYPT)
        ]);

        if (!$response) {
            $error = [
                "message" => "There was an error creating the user",
            ];

            return require('../views/Error/404.php');
        }

        $auth = new AuthController();
        return $auth->login($user->get_email(), $user->get_password());
    }

    /** Display a specified user */
    public function show(int $id) {
        $stmt = $this->connection->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(["id" => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                "status" => false,
                "message" => "The user id does not exists"
            ];
        }

        $id = $user["id"];
        $user = new User(...$user);

        return [
            "status" => false,
            "user" => $user->set_id($id),
            "message" => "User found"
        ];
    }

    /** Show the form for editing the specified user */
    public function edit() {
    }

    /** Update the specified user in storage */
    public function update(User $user) {
        $stmt = $this->connection->prepare("UPDATE `users` SET `username` = ?, `email` = ?, `password` = ?");

        if (!$stmt->execute([$user->get_username(), $user->get_email(), $user->get_password()])) {
            return [
                "status" => false,
                "message" => "There was an error updating the user"
            ];
        }

        return [
            "status" => true,
            "message" => "The user was updated successfully"
        ];
    }

    /** Remove the specified user from storage */
    public function destroy(int $id) {
        $stmt = $this->connection->prepare("DELETE FROM `users` WHERE `id` = ?");

        if (!$stmt->execute([$id])) {
            return [
                "status" => false,
                "message" => "There was an error removing the user"
            ]; //¿Manejar con Exception?
        }

        return [
            "status" => true,
            "message" => "The user was removed successfully"
        ];
    }

    public function get_user_by_email(string $email) {
        $stmt = $this->connection->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->execute(["email" => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $id = $user["id"];
        $user = new User(...$user);

        return $user->set_id($id);
    }

    private function check_if_user_exists_by_username(string $username) {
        $stmt = $this->connection->prepare("SELECT COUNT(*) AS count FROM `users` WHERE `username` = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC)["count"];

        if (!$user) {
            return false;
        }

        return true;
    }
    private function check_if_user_exists_by_email(string $email) {
        $stmt = $this->connection->prepare("SELECT COUNT(*) AS count FROM `users` WHERE `email` = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC)["count"];

        if (!$user) {
            return false;
        }

        return true;
    }

    private function check_if_user_exists(User $user) {
        if ($this->check_if_user_exists_by_email($user->get_email())) {
            return [
                "status" => true,
                "message" => "The email alredy exists",
                "input" => "email"
            ];
        }
        
        if ($this->check_if_user_exists_by_username($user->get_username())) {
            return [
                "status" => true,
                "message" => "The username alredy exists",
                "input" => "username"
            ];
        }

        return [
            "status" => false,
            "message" => "The user does not exists"
        ];
    }
}
