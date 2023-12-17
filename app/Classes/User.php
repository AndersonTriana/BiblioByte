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
    ) {
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername($username): self {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail($email): self {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword($password): self {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId($id): self {
        $this->id = $id;

        return $this;
    }

    public function getCreatedAt(): ?string {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): self {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?string {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at): self {
        $this->updated_at = $updated_at;

        return $this;
    }
}
