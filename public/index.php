<?php

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use RlyBadBB\Http\Request;
use RlyBadBB\Routing\FrontController;
use RlyBadBB\Routing\Router;

require __DIR__ . '/../vendor/autoload.php';

$routes = require __DIR__ . '/../config/routes.php';

$router = new Router($routes);

$serverRequest = Request::fromGlobals();
$app = new FrontController($router, $serverRequest);

(new SapiEmitter())->emit($app->resolve()->toPsr7());
