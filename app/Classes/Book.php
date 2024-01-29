<?php

namespace App\Classes;

class Book {
    private $id;
    private $user_id;
    private $title;
    private $file_name;
    private $file_path;
    private $current_page;
    private $last_read_date;
    private $author;
    private $publication_year;
    private $cover_name;
    private $cover_path;
    private $pages;
    private $created_at;
    private $updated_at;

    public function __construct(
        int $user_id,
        string $title,
        string $file_name,
        string $file_path,
        ?int $id = null,
        ?int $current_page = 0,
        ?string $last_read_date = "",
        ?string $author = "",
        ?int $pages = 0,
        ?int $publication_year = 0,
        ?string $cover_name = null,
        ?string $cover_path = null,
        ?string $created_at = null,
        ?string $updated_at = null,
    ) {
        $this->set_user_id($user_id);
        $this->set_title($title);
        $this->set_file_name($file_name);
        $this->set_file_path($file_path);
        $this->set_id($id);
        $this->set_current_page($current_page);
        $this->set_last_read_date($last_read_date);
        $this->set_author($author);
        $this->set_pages($pages);
        $this->set_publication_year($publication_year);
        $this->set_cover_name($cover_name);
        $this->set_cover_path($cover_path);
        $this->set_created_at($created_at);
        $this->set_updated_at($updated_at);
    }

    public function get_id(): ?int {
        return $this->id;
    }

    public function set_id($id): self {
        $this->id = $id;

        return $this;
    }

    public function get_user_id(): int {
        return $this->user_id;
    }

    public function set_user_id($user_id): self {
        $this->user_id = $user_id;

        return $this;
    }

    public function get_title(): string {
        return $this->title;
    }

    public function set_title($title): self {
        $this->title = $title;

        return $this;
    }

    public function get_file_name() {
        return $this->file_name;
    }

    public function set_file_name($file_name): self {
        $this->file_name = $file_name;

        return $this;
    }

    public function get_file_path(): string {
        return $this->file_path;
    }

    public function set_file_path($file_path): self {
        $this->file_path = $file_path;

        return $this;
    }

    public function get_current_page() {
        return $this->current_page;
    }

    public function set_current_page($current_page): self {
        $this->current_page = $current_page;

        return $this;
    }

    public function get_last_read_date() {
        return $this->last_read_date;
    }

    public function set_last_read_date($last_read_date): self {
        $this->last_read_date = $last_read_date;

        return $this;
    }

    public function get_author(): ?string {
        return $this->author;
    }

    public function set_author($author): self {
        $this->author = $author;

        return $this;
    }

    public function get_publication_year(): ?int {
        return $this->publication_year;
    }

    public function set_publication_year($publication_year): self {
        $this->publication_year = $publication_year;

        return $this;
    }

    public function get_cover_name() {
        return $this->cover_name;
    }

    public function set_cover_name($cover_name): self {
        $this->cover_name = $cover_name;

        return $this;
    }

    public function get_cover_path(): ?string {
        return $this->cover_path;
    }

    public function set_cover_path($cover_path): self {
        $this->cover_path = $cover_path;

        return $this;
    }

    public function get_pages(): ?int {
        return $this->pages;
    }

    public function set_pages($pages): self {
        $this->pages = $pages;

        return $this;
    }

    public function get_created_at(): ?string {
        return $this->created_at;
    }

    public function set_created_at($created_at): self {
        $this->created_at = $created_at;

        return $this;
    }

    public function get_updated_at(): ?string {
        return $this->updated_at;
    }

    public function set_updated_at($updated_at): self {
        $this->updated_at = $updated_at;

        return $this;
    }
}
