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

            $func = function (array $book) {
                $cover_path = $book["cover_path"];

                if ($cover_path) {
                    if (file_exists($cover_path)) {
                        $cover_mime_type = mime_content_type($cover_path);
                        $cover_path = base64_encode(file_get_contents($cover_path));

                        $book["cover_path"] = "data:$cover_mime_type;base64,$cover_path";
                    }
                }

                return new Book(...$book);
            };

            return [
                "status" => true,
                "books" => array_map($func, $books)
            ];
        }

        header("Location: /login");
        exit();
    }

    /* Show the form for creating a new book */
    public function create() {
        if ($_SESSION['user_id'] ?? null) {
            return require('../views/Books/UploadBook.php');
        }

        $this->redirect_to_not_found();
    }

    /* Store a newly created book in storage */
    public function store(string $title, array $book, array $cover = null, string $author = "", int $pages = 0, int $publication_year = null) {
        $user_id = $_SESSION["user_id"] ?? null;

        if ($user_id) {
            $user_folder = $this->create_user_folder();

            if (strlen($title) > MAX_BOOK_NAME_LENGTH) {
                $error = [
                    "message" => "The title is too large (Max 60)",
                    "input" => "title"
                ];

                return require('../views/Books/UploadBook.php');
            }

            // Validate and move cover file
            $cover_path = "";

            if ($cover["name"]) {

                if (!$this->is_valid_cover_file($cover["name"], $cover["size"])) {
                    $error = [
                        "message" => "The book cover is not valid",
                        "input" => "cover"
                    ];

                    return require('../views/Books/UploadBook.php');
                }

                $user_covers_folder = $user_folder . "/covers";
                $cover_file_name = $this->get_unique_file_name($user_covers_folder, $cover["name"]);
                $cover_path = $user_covers_folder . "/" . $cover_file_name;

                if (!move_uploaded_file($cover["tmp_name"], $cover_path)) {
                    $error = [
                        "message" => "There was an error uploading the book cover",
                        "input" => "cover"
                    ];
                    return require('../views/Books/UploadBook.php');
                }
            }

            // Validate and move book file
            if (!$this->is_valid_book_file($book["name"], $book["size"])) {
                $error = [
                    "message" => "The book file is not valid",
                    "input" => "book"
                ];

                return require('../views/Books/UploadBook.php');
            }

            $user_books_folder = $user_folder . "/books";
            $book_file_name = $this->get_unique_file_name($user_books_folder, $book["name"]);
            $book_path = $user_books_folder . "/" . $book_file_name;

            if (!move_uploaded_file($book["tmp_name"], $book_path)) {
                $error = [
                    "message" => "There was an error uploading de book",
                    "input" => "book"
                ];

                return require('../views/Books/UploadBook.php');
            }

            //Upload book to database
            $stmt = $this->connection->prepare(
                "INSERT INTO `books` (`user_id`, `title`, `author`, `file_name`, `file_path`, `cover_name`, `cover_path`, `pages`, `publication_year`) 
                            VALUES (:user_id, :title,  :author, :file_name,  :file_path, :cover_name,  :cover_path,  :pages,  :publication_year)"
            );

            $stmt->execute([
                "user_id"    => $user_id,
                "title"      => $title,
                "author"     => $author,
                "file_name"  => $book_file_name,
                "file_path"  => $book_path,
                "cover_name" => $cover_file_name,
                "cover_path" => $cover_path,
                "pages"      => $pages,
                "publication_year" => $publication_year
            ]);

            header("Location: /home");
            exit();
        }

        $this->redirect_to_not_found();
    }

    /* Display a specified book */
    public function show(int $id) {
        $user_id = $_SESSION["user_id"] ?? false;

        if (!$user_id) {
            header("Location: /login");
            exit();
        }

        $book = $this->find_by_id($id);

        if (!$book["status"]) {
            $this->redirect_to_not_found();
        }

        $book = $book["book"];

        if ($book->get_user_id() != $_SESSION["user_id"]) {
            header("Location: /login");
            exit();
        }

        $cover_path = $book->get_cover_path();
        $cover_uri = null;

        if ($cover_path) {
            if (file_exists($cover_path)) {
                $cover_mime_type = mime_content_type($cover_path);
                $cover_path = base64_encode(file_get_contents($cover_path));

                $cover_uri = "data:$cover_mime_type;base64,$cover_path";
            }
        }

        return require("../views/Books/Book.php");
    }

    /* Show the form for editing the specified book */
    public function edit(int $id = null) {
        if (!$id) {
            $this->redirect_to_not_found();
        }

        $user_id = $_SESSION["user_id"] ?? false;

        if (!$user_id) {
            header("Location: /login");
            exit();
        }

        $book = $this->find_by_id($id);

        if (!$book["status"]) {
            $this->redirect_to_not_found();
        }

        $book = $book["book"];

        if ($book->get_user_id() != $_SESSION["user_id"]) {
            header("Location: /login");
            exit();
        }

        $cover_path = $book->get_cover_path();
        $cover_uri = null;

        if ($cover_path) {
            if (file_exists($cover_path)) {
                $cover_mime_type = mime_content_type($cover_path);
                $cover_path = base64_encode(file_get_contents($cover_path));

                $cover_uri = "data:$cover_mime_type;base64,$cover_path";
            }
        }

        return require("../views/Books/EditBook.php");
    }

    /* Update the specified book in storage */
    public function update(int $id, string $title, array $book, array $cover = null, string $author = "", int $pages = 0, int $publication_year = null) {
        $user_id = $_SESSION["user_id"] ?? null;
        $new_book = $book;

        if ($user_id) {

            $book = $this->find_by_id($id)["book"];

            $user_folder = $this->create_user_folder();
            $query = "";
            $query_params = ["id" => $id, "user_id" => $user_id];

            if ($title && $title != $book->get_title()) {
                if (strlen($title) > MAX_BOOK_NAME_LENGTH) {
                    $error = [
                        "message" => "The title is too large (Max 60)",
                        "input" => "title"
                    ];

                    return require('../views/Books/EditBook.php');
                } else {
                    $query .= "`title` = :title";
                    $query_params["title"] = $title;
                }
            }

            if ($author && $author != $book->get_author()) {
                if (strlen($author) > MAX_AUTHOR_NAME_LENGTH) {
                    $error = [
                        "message" => "The author name is too large (Max 60)",
                        "input" => "author"
                    ];

                    return require('../views/Books/EditBook.php');
                } else {
                    $query .= $query ? ", " : "";
                    $query .= "`author` = :author";
                    $query_params["author"] = $author;
                }
            }

            // Validate and move cover file
            if ($cover["name"]) {

                if (!$this->is_valid_cover_file($cover["name"], $cover["size"])) {
                    $error = [
                        "message" => "The book cover is not valid",
                        "input" => "cover"
                    ];

                    return require('../views/Books/EditBook.php');
                }

                if (!file_exists($book->get_cover_path())) {
                    $error = [
                        "message" => "There was an error uploading the book cover",
                        "input" => "cover"
                    ];

                    return require('../../views/Books/EditBook.php');
                }

                unlink($book->get_cover_path());

                $user_covers_folder = $user_folder . "/covers";
                $cover_file_name = $this->get_unique_file_name($user_covers_folder, $cover["name"]);
                $cover_path = $user_covers_folder . "/" . $cover_file_name;

                if (!move_uploaded_file($cover["tmp_name"], $cover_path)) {
                    $error = [
                        "message" => "There was an error uploading the book cover",
                        "input" => "cover"
                    ];

                    return require('../views/Books/EditBook.php');
                }

                $query .= $query ? ", " : "";
                $query .= "`cover_name` = :cover_name, `cover_path` = :cover_path";
                $query_params["cover_name"] = $cover_file_name;
                $query_params["cover_path"] = $cover_path;;
            }

            if ($new_book["name"]) {
                // Validate and move book file
                if (!$this->is_valid_book_file($new_book["name"], $new_book["size"])) {
                    $error = [
                        "message" => "The book file is not valid",
                        "input" => "book"
                    ];

                    return require('../views/Books/EditBook.php');
                }

                if (!file_exists($book->get_file_path())) {
                    $error = [
                        "message" => "There was an error uploading the book file",
                        "input" => "book"
                    ];

                    return require('../views/Books/EditBook.php');
                }

                unlink($book->get_file_path());

                $user_books_folder = $user_folder . "/books";
                $book_file_name = $this->get_unique_file_name($user_books_folder, $new_book["name"]);
                $book_path = $user_books_folder . "/" . $book_file_name;

                if (!move_uploaded_file($new_book["tmp_name"], $book_path)) {
                    $error = [
                        "message" => "There was an error uploading de book",
                        "input" => "book"
                    ];

                    return require('../views/Books/EditBook.php');
                }

                $query .= $query ? ", " : "";
                $query .= "`file_name` = :file_name, `file_path` = :file_path";
                $query_params["file_name"] = $book_file_name;
                $query_params["file_path"] = $book_path;
            }

            if ($pages) {
                $query .= $query ? ", " : "";
                $query .= "`pages` = :pages";
                $query_params["pages"] = $pages;
            }

            if ($publication_year) {
                $query .= $query ? ", " : "";
                $query .= "`publication_year` = :publication_year";
                $query_params["publication_year"] = $publication_year;
            }

            if (!$query) {
                header("Location: " . $_SERVER["REQUEST_URI"]);
                exit();
            }

            $query = "UPDATE `books` SET " . $query . " WHERE `id` = :id AND `user_id` = :user_id";

            $stmt = $this->connection->prepare($query);
            $stmt->execute($query_params);

            header("Location: /book/$id");
            exit();
        }

        $this->redirect_to_not_found();
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

    private function find_by_id(int $id) {
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

    private function check_if_book_exists_by_id(int $id) {
        $stmt = $this->connection->prepare("SELECT COUNT(*) AS count FROM `books` WHERE `id` = :id");
        $stmt->execute(["id" => $id]);

        $book = $stmt->fetch(PDO::FETCH_ASSOC)["count"];

        if (!$book) {
            return false;
        }

        return true;
    }

    private function is_valid_book_file(string $file_name, int $size): bool {
        return $size < MAX_BOOK_FILE_SIZE && pathinfo($file_name, PATHINFO_EXTENSION) == "pdf";
    }

    private function is_valid_cover_file(string $file_name, int $size): bool {
        return $size < MAX_COVER_FILE_SIZE && (pathinfo($file_name, PATHINFO_EXTENSION) == "jpg" || pathinfo($file_name, PATHINFO_EXTENSION) == "png");
    }

    private function create_user_folder(): string {
        $user_folder = "../" . STORAGE_PATH . hash("md4", $_SESSION["user_id"]);

        if (!is_dir($user_folder) && !file_exists($user_folder)) {
            mkdir(
                $user_folder,
                0755,
                false
            );
            mkdir(
                $user_folder . "/books",
                0755,
                false
            );
            mkdir(
                $user_folder . "/covers",
                0755,
                false
            );
        }

        return $user_folder;
    }

    private function get_unique_file_name(string $folder, string $file_name): string {
        $file_name_len = strlen($file_name);

        if ($file_name_len > MAX_BOOK_NAME_LENGTH) {
            $file_name = substr($file_name, $file_name_len - MAX_BOOK_NAME_LENGTH);
        }

        $counter = 1;

        while (file_exists($folder . "/" . $file_name)) {
            $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
            $counter++;
        }

        return $file_name;
    }

    private function redirect_to_not_found(): void {
        header("Location: /404");
        exit();
    }
}
