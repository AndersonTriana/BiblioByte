<?php

namespace App\Controllers;

use App\Classes\Book;
use Database\DatabaseConnection;
use PDO;

class BookController {

    private $connection;

    public function __construct() {
        $this->connection = DatabaseConnection::get_instance()->get_database_connection();
    }

    /* Display a list of the books */
    public function index() {
        if ($_SESSION["user_id"]) {
            $stmt = $this->connection->prepare("SELECT * FROM `books` WHERE `user_id` = :id");

            $stmt->execute(["id" => $_SESSION["user_id"]]);

            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$books) {
                return [
                    "status" => false,
                    "message" => "The user has no books"
                ];
            }

            $func = function (array $books) {
                return new Book(...$books);
            };

            return [
                "status" => true,
                "books" => array_map($func, $books)
            ];
        }
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

        $stmt->execute([
            "user_id"    => $book->get_user_id(),
            "title"      => $book->get_title(),
            "author"     => $book->get_author(),
            "file_path"  => $book->get_file_path(),
            "cover_path" => $book->get_cover_path(),
            "pages"      => $book->get_pages(),
            "publication_year" => $book->get_publication_year()
        ]);
    }

    /* Display a specified book */
    public function show(int $id) {
        $stmt = $this->connection->prepare("SELECT * FROM `books` WHERE `id` = :id");
        $stmt->execute(["id" => $id]);

        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$book) {
            return [
                "status" => false,
                "message" => "The book id does not exists"
            ];
        }

        $id = $book["id"];
        $book = new Book(...$book);

        return [
            "status" => true,
            "book" => $book->set_id($id),
            "message" => "Book found"
        ];
    }

    /* Show the form for editing the specified book */
    public function edit() {
    }

    /* Update the specified book in storage */
    public function update(Book $book) {
        $stmt = $this->connection->prepare(
            "UPDATE `books` 
                SET `user_id` = :user_id, `title` = :title, `author` = :author, `file_path` = :file_path, `cover_path` = :cover_path, `pages` = :pages, `publication_year` = :publication_year
              WHERE `id` = :id AND `user_id` = :user_id"
        );

        $stmt->execute([
            "id"         => $book->get_id(),
            "user_id"    => $book->get_user_id(),
            "title"      => $book->get_title(),
            "author"     => $book->get_author(),
            "file_path"  => $book->get_file_path(),
            "cover_path" => $book->get_cover_path(),
            "pages"      => $book->get_pages(),
            "publication_year" => $book->get_publication_year()
        ]);

        return [
            "status" => true,
            "message" => "The book was updated successfully"
        ];
    }

    /* Remove the specified book from storage */
    public function destroy(int $id) {
        $stmt = $this->connection->prepare("DELETE FROM `books` WHERE `id` = :id AND `user_id` = :user_id");

        if (!$this->check_if_book_exists_by_id($id)) {
            return [
                "status" => false,
                "message" => "The book does not exists"
            ];
        }

        $stmt->execute([
            "id"      => $id,
            "user_id" => $_SESSION["user_id"]
        ]);

        return [
            "status" => true,
            "message" => "The book was removed successfully"
        ];
    }

    private function check_if_book_exists_by_id(int $id) {
        $stmt = $this->connection->prepare("SELECT COUNT(*) AS count FROM `books` WHERE `id` = :id");
        $stmt->execute(["id" => $id]);

        $book = $stmt->fetch(PDO::FETCH_ASSOC)["count"];

        if (!$book) {
            return false;
        }

        return true;
    }
}
