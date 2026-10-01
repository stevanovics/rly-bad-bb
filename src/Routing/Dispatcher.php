<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

use RlyBadBB\Exceptions\{ActionNotFoundException, ControllerNotFoundException, WrongTypeException};
use RlyBadBB\Http\{Request, Response};
use Stringable;

class Dispatcher
{
    /**
     * Parse the route and get the appropriate response for it.
     *
     * @param array<int, mixed>|callable $route If array first member is controller, second is action.
     * @param Request $request HTTP request.
     *
     * @return Response
     */
    public function dispatch(array|callable $route, Request $request): Response
    {
        if (is_callable($route)) {
            return $this->handleCallable($route, $request);
        }

        return $this->handleControllerAction($route, $request);
    }

    /**
     * Handle routes that are callable.
     *
     * @param callable $route Route callable.
     * @param Request $request HTTP request.
     */
    private function handleCallable(callable $route, Request $request): Response
    {
        /** @var Response|Stringable */
        $response = $route($request);

        if ($response instanceof Response) {
            return $response;
        }

        if ($response instanceof Stringable) {
            return Response::html((string) $response);
        }

        throw WrongTypeException::forMultipleTypes(
            variable: '$response',
            actualType: gettype($response),
            expectedTypes: [Response::class, 'string'],
        );
    }

    /**
     * Handle routes that specify controller and action.
     *
     * @param array<int, mixed> $route First member is controller, second is action.
     * @param Request $request HTTP request.
     */
    private function handleControllerAction(array $route, Request $request): Response
    {
        [$controller, $action] = $route;

        if (! is_string($controller)) {
            throw WrongTypeException::forString(
                variable: '$controller',
                actualType: gettype($controller),
            );
        }

        if (class_exists($controller)) {
            $controller = new $controller();
        } else {
            throw ControllerNotFoundException::forClass(class: $controller);
        }

        if (! is_string($action)) {
            throw WrongTypeException::forString(
                variable: '$controller',
                actualType: gettype($action),
            );
        }

        if (! method_exists($controller, $action)) {
            throw ActionNotFoundException::forAction(action: $action, class: $controller::class);
        }

        /** @var Response|Stringable */
        $response = $controller->$action($request);

        if ($response instanceof Response) {
            return $response;
        }

        return Response::html((string) $response);
    }
}
