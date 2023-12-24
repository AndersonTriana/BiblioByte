<?php

namespace App\Controllers;

use App\Classes\Book;
use Database\DatabaseConnection;

class BookController {

    private $connection;

    public function __construct() {
        $this->connection = DatabaseConnection::get_instance()->get_database_connection();
    }

    /* Display a list of the books */
    public function index() {
    }

    /* Show the form for creating a new book */
    public function create() {
    }

    /* Store a newly created book in storage */
    public function store(Book $book) {

        $stmt = $this->connection->prepare(
            "INSERT INTO `books` (`user_id`, `title`, `author`, `file_path`, `cover_path`, `pages`, `publication_year`) 
                        VALUES (:user_id,  :title,  :author,  :file_path,  :cover_path,  :pages,  :publication_year)"
        );

        var_dump($stmt->execute([
            "user_id"    => $book->get_user_id(),
            "title"      => $book->get_title(),
            "author"     => $book->get_author(),
            "file_path"  => $book->get_file_path(),
            "cover_path" => $book->get_cover_path(),
            "pages"      => $book->get_pages(),
            "publication_year" => $book->get_publication_year()
        ]));
    }

    /* Display a specified book */
    public function show(int $id) {
    }

    /* Show the form for editing the specified book */
    public function edit() {
    }

    /* Update the specified book in storage */
    public function update() {
    }

    /* Remove the specified book from storage */
    public function destroy() {
    }
}
