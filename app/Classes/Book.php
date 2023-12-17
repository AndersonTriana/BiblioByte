<?php

namespace App\Classes;

class User {
    private $id;
    private $user_id;
    private $title;
    private $file_path;
    private $current_page;
    private $last_read_date;
    private $author;
    private $publication_year;
    private $cover_path;
    private $pages;
    private $created_at;
    private $updated_at;

    public function __construct(
        int $user_id,
        string $title,
        string $file_path,
        int $current_page = 0,
        string $last_read_date = "",
        string $author = "",
        int $pages = 0,
        int $publication_year = 0,
        string $cover_path = ""
    ) {
        $this->setUserId($user_id);
        $this->setTitle($title);
        $this->setFilePath($file_path);
        $this->setCurrentPage($current_page);
        $this->setLastReadDate($last_read_date);
        $this->setAuthor($author);
        $this->setPages($pages);
        $this->setPublicationYear($publication_year);
        $this->setCoverPath($cover_path);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId($id): self {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function setUserId($user_id): self {
        $this->user_id = $user_id;

        return $this;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle($title): self {
        $this->title = $title;

        return $this;
    }

    public function getFilePath(): string {
        return $this->file_path;
    }

    public function setFilePath($file_path): self {
        $this->file_path = $file_path;

        return $this;
    }

    public function getCurrentPage() {
        return $this->current_page;
    }

    public function setCurrentPage($current_page): self {
        $this->current_page = $current_page;

        return $this;
    }

    public function getLastReadDate() {
        return $this->last_read_date;
    }

    public function setLastReadDate($last_read_date): self {
        $this->last_read_date = $last_read_date;

        return $this;
    }

    public function getAuthor(): ?string {
        return $this->author;
    }

    public function setAuthor($author): self {
        $this->author = $author;

        return $this;
    }

    public function getPublicationYear(): ?int {
        return $this->publication_year;
    }

    public function setPublicationYear($publication_year): self {
        $this->publication_year = $publication_year;

        return $this;
    }

    public function getCoverPath(): ?string {
        return $this->cover_path;
    }

    public function setCoverPath($cover_path): self {
        $this->cover_path = $cover_path;

        return $this;
    }

    public function getPages(): ?int {
        return $this->pages;
    }

    public function setPages($pages): self {
        $this->pages = $pages;

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
