<?php

namespace App\Classes;

class Router {
    private static $instance;
    private $routes = [];

    public static function get_instance(): self {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public function add_route(string $method, string $resource, string $controller, string $action) {
        $this->routes[] = [
            "method" => $method,
            "route" => substr($resource, 1),
            "controller" => $controller,
            "action" => $action
        ];
    }

    public function route(string $method, string $resource, array $params = []) {
        $slug = explode("/", $resource);
        $resource = $slug[0] == "" ? "login" : $slug[0];
        $id = $slug[1] ?? null;

        foreach ($this->routes as $route) {
            if ($route["method"] == $method && $route["route"] == $resource) {
                $controller = "App\\Controllers\\" . $route["controller"];
                $action = $route["action"];

                $controller = new $controller();

                if (!method_exists($controller, $action)) {
                    return [
                        "status" => false,
                        "message" => "The action does not exists"
                    ];
                }

                return call_user_func_array([$controller, $action], [$id]);
            }
        }

        return [
            "status" => false,
            "message" => "The route does not exists"
        ];
    }
}
