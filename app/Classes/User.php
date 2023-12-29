<?php

namespace App\Classes;

class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $created_at;
    private $updated_at;

    public function __construct(
        string $username,
        string $email,
        string $password,
        string $created_at = null,
        string $updated_at = null,
        string $id = null,
    ) {
        $id != null ?? $this->set_id($id);
        $this->set_username($username);
        $this->set_email($email);
        $this->set_password($password);
        $created_at != null ?? $this->set_created_at($created_at);
        $updated_at != null ?? $this->set_updated_at($updated_at);
    }

    public function get_username(): string {
        return $this->username;
    }

    public function set_username(string $username): self {
        $this->username = $username;

        return $this;
    }

    public function get_email(): string {
        return $this->email;
    }

    public function set_email(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function get_password(): string {
        return $this->password;
    }

    public function set_password(string $password): self {
        $this->password = $password;

        return $this;
    }

    public function get_id(): ?int {
        return $this->id;
    }

    public function set_id(int $id): self {
        $this->id = $id;

        return $this;
    }

    public function get_created_at(): ?string {
        return $this->created_at;
    }

    public function set_created_at(string $created_at): self {
        $this->created_at = $created_at;

        return $this;
    }

    public function get_updated_at(): ?string {
        return $this->updated_at;
    }

    public function set_updated_at(string $updated_at): self {
        $this->updated_at = $updated_at;

        return $this;
    }
}
