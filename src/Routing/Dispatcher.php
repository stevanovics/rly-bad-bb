<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

use RlyBadBB\Http\Request;
use RlyBadBB\Http\Response;
use Stringable;

class Dispatcher
{
    /**
     * Parse the route and get the appropriate response for it.
     *
     * @param array<int, string> $route First member is controller, second is action.
     * @param Request $request HTTP Request.
     *
     * @return Response
     */
    public function dispatch(array $route, Request $request): Response
    {
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
        $response = $controller->$action($request);

        if ($response instanceof Response) {
            return $response;
        }

        return Response::html((string) $response);
    }
}
