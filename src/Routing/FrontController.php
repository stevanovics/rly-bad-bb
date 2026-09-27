<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

use RlyBadBB\Http\Request;
use RlyBadBB\Http\Response;
use Stringable;

class FrontController
{
    /**
     * Construct front controller.
     * @param Router $router Router.
     * @param Request $request HTTP $request.
     */
    public function __construct(private Router $router, private Request $request)
    {
    }

    /**
     * Return appropriate response depending on the route.
     *
     * @return Response
     */
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

        /** @var Response|Stringable */
        $response = $controller->$action($this->request);

        if ($response instanceof Response) {
            return $response;
        }

        return Response::html((string) $response);
    }
}
