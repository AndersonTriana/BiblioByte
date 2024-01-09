<?php

namespace App\Controllers;

class HomeController {
    public function index(){
        
    }
    
    public function error(){
        return require('../views/Errors/404.php');
    }
}