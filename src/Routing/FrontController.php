<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

use RlyBadBB\Http\Request;
use RlyBadBB\Http\Response;

class FrontController
{
    public function __construct(private Router $router, private Request $request)
    {
    }

    public function resolve(): Response
    {
        $route = $this->router->match($this->request);

        if ($route === null) {
            return Response::notFound();
        }

        [$controller, $action] = $route;

        if (class_exists($controller)) {
            $controller = new $controller();
        } else {
            //TODO: Log controller not found error.
            return Response::genericServerError();
        }

        if (! method_exists($controller, $action)) {
            //TODO: Log controller action not found error.
            return Response::genericServerError();
        }

        $response = $controller->$action($this->request);

        if ($response instanceof Response) {
            return $response;
        }

        return Response::text((string) $response);
    }
}
