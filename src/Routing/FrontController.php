<?php

declare(strict_types=1);

namespace RlyBadBB\Routing;

use Exception;
use RlyBadBB\Http\Request;
use RlyBadBB\Http\Response;

class FrontController
{
    /**
     * Construct front controller.
     * @param Router $router Router.
     * @param Request $request HTTP $request.
     */
    public function __construct(
        private Router $router,
        private Request $request,
        private Dispatcher $dispatcher,
    ) {
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

        try {
            return $this->dispatcher->dispatch($route, $this->request);
        } catch (Exception $e) {
            // TODO: log the exception.
            return Response::genericServerError();
        }
    }
}
