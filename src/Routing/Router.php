<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

use RlyBadBB\Http\Request;

class Router
{
    /**
     * Construct the router.
     *
     * @param array<string, array<string, array<int, string>>> $routes All configured routes.
     */
    public function __construct(private array $routes)
    {
    }

    /**
     * Get the controller and the method to invoke from the request's method and target.
     *
     * @param Request $request The HTTP request.
     *
     * @return array<int, mixed>|callable|null If array first element is the controller class, second is the action.
     *     Null is returned if no rute has been matched.
     */
    public function match(Request $request): array|callable|null
    {
        return $this->routes[$request->method()][$request->path()] ?? null;
    }
}
