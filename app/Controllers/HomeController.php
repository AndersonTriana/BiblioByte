<?php

namespace App\Controllers;

use App\Controllers\BookController;

class HomeController {
    public function index() {
        $bookController = new BookController();

        $books = $bookController->index();

        return require("../views/Home/Home.php");
    }

    public function error() {
        return require('../views/Errors/404.php');
    }
}
