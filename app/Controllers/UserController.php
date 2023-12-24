<?php

namespace App\Controllers;

use App\Classes\User;
use Database\DatabaseConnection;
use PDO;

class UserController {

    private $connection;

    public function __construct() {
        $this->connection = DatabaseConnection::get_instance()->get_database_connection();
    }

    /** Show the form for creating a new user */
    public function create() {
    }

    /** Store a newly created user in storage */
    public function store(User $user): array {

        $username = strtolower(trim($user->get_username()));

        if (preg_match("/[^a-zA-Z0-9]/", $username)) {
            return [
                "status" => false,
                "message" => "The username can't contain special characters"
            ];
        } else if (strlen($username) > 16) {
            return [
                "status" => false,
                "message" => "The username can't have more than 16 characters"
            ];
        }

        $email = strtolower(trim($user->get_email()));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                "status" => false,
                "message" => "The email address is not valid"
            ];
        }

        $user_exists = $this->check_if_user_exists($user);

        if ($user_exists["status"]) {
            return [
                "status" => false,
                "message" => $user_exists["message"]
            ];
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
            return [
                "status" => false,
                "message" => "There was an error creating the user"
            ];
        }

        return [
            "status" => true,
            "message" => "The user was created successfully"
        ];
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

        return [
            "status" => false,
            "user" => new User(...$user),
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
            "message" => "User removed successfully"
        ];
    }

    public function validate_login(string $email, string $password) {
        $user = $this->get_user_by_email($email);

        if (!$user) {
            return [
                "status" => false,
                "message" => "The email is not connected to an account"
            ];
        }

        if (!password_verify($password, $user->get_password())) {
            return [
                "status" => false,
                "message" => "Incorrect password"
            ];
        }

        return [
            "status" => true,
            "user" => $user,
            "message" => "Login successful"
        ];
    }

    private function get_user_by_email(string $email) {
        $stmt = $this->connection->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->execute(["email" => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        return new User(...$user);
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
                "message" => "The email alredy exists"
            ];
        }

        if ($this->check_if_user_exists_by_username($user->get_username())) {
            return [
                "status" => true,
                "message" => "The username alredy exists"
            ];
        }

        return [
            "status" => false,
            "message" => "The user does not exists"
        ];
    }
}
