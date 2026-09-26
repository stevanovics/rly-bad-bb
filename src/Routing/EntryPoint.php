<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

class EntryPoint
{
    public function __construct(private array $routes)
    {
    }

    public function resolve(): void
    {
        if (empty($this->routes)) {
            $this->sendResponse(500, 'No routes defined.');
        }

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$path])) {
            $route = $this->routes[$path];
            $controller = $route[0];

            if (class_exists($controller)) {
                $controller = new $controller();
            } elseif (class_exists('RlyBadBB\\Controllers\\' . $controller)) {
                $controller = 'RlyBadBB\\Controllers\\' . $controller;
                $controller = new $controller();
            } else {
                $this->sendResponse(
                    404,
                    'Controller ' . $controller . ' not found',
                );
            }

            $method = $route[1];

            if (! method_exists($controller, $method)) {
                http_response_code(404);
                echo 'Method ' . $method . ' does not exist on ' . get_class($controller) . '.';
            }

            $controller->$method();
        } else {
            $this->sendResponse(404, '404');
        }
    }

    private function sendResponse(int $responseCode, string $message): void
    {
        http_response_code($responseCode);
        echo htmlspecialchars($message);
    }
}
