<?php

use App\Classes\Router;

function charge_routes() {
    $router = Router::get_instance();
    
    $router->add_route("GET",  "/register",  "UserController", "create");
    $router->add_route("POST", "/register",  "UserController", "store");
    $router->add_route("GET",  "/login",     "AuthController", "index");
    $router->add_route("POST", "/login",     "AuthController", "login");
    $router->add_route("GET",  "/logout",    "AuthController", "logout");
    $router->add_route("GET",  "/home",      "HomeController", "index");
    $router->add_route("GET",  "/404",       "HomeController", "error");
    $router->add_route("GET",  "/upload",    "BookController", "create");
    $router->add_route("POST", "/upload",    "BookController", "store");
    $router->add_route("GET",  "/book/id",   "BookController", "show");
    $router->add_route("POST", "/delete/id", "BookController", "destroy");
    $router->add_route("GET",  "/edit/id",   "BookController", "edit");
    $router->add_route("POST", "/edit",      "BookController", "update");
    $router->add_route("GET",  "/read/id",   "BookController", "read");
    $router->add_route("GET",  "/getbook/id","BookController", "book");
}
