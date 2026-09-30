<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

use RlyBadBB\Http\Request;
use RlyBadBB\Http\Response;
use Throwable;

class FrontController
{
    /**
     * Construct front controller.
     *
     * @param Router $router Router.
     */
    public function __construct(
        private Router $router,
        private Dispatcher $dispatcher,
    ) {
    }

    /**
     * Return appropriate response depending on the route.
     *
     * @param Request $request HTTP $request.
     *
     * @return Response
     */
    public function resolve(Request $request): Response
    {
        $route = $this->router->match($request);

        if ($route === null) {
            return Response::notFound();
        }

        try {
            return $this->dispatcher->dispatch($route, $request);
        } catch (Throwable) {
            // TODO: log the exception.
            return Response::genericServerError();
        }
    }
}
