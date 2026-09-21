<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

class EntryPoint
{
    public function resolve(): void
    {
        $routes = [
            '/'     => ['HomeController', 'index', 'GET'],
            '/test' => ['HomeController', 'test', 'GET'],
        ];

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($routes[$path])) {
            $route = $routes[$path];
            $controller = $route[0];

            if (class_exists($controller, false)) {
                $controller = new $controller();
            } elseif (class_exists('RlyBadBB\\Controllers\\' . $controller)) {
                $controller = 'RlyBadBB\\Controllers\\' . $controller;
                $controller = new $controller();
            } else {
                echo 'Controller ' . $controller . ' not found';
                die();
            }

            $method = $route[1];

            if (! method_exists($controller, $method)) {
                echo 'Method ' . $method . ' does not exist on ' . get_class($controller) . '.';
                die();
            }

            $controller->$method();
        } else {
            echo '404';
        }
    }
}
