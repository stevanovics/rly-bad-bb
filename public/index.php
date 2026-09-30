<?php

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use RlyBadBB\Http\Request;
use RlyBadBB\Routing\Dispatcher;
use RlyBadBB\Routing\FrontController;
use RlyBadBB\Routing\Router;

require __DIR__ . '/../vendor/autoload.php';

/** @var array<string, array<string, array<int, string>>> */
$routes = require __DIR__ . '/../config/routes.php';

$router = new Router($routes);
$dispatcher = new Dispatcher();
$app = new FrontController($router, $dispatcher);

$request = Request::fromGlobals();

(new SapiEmitter())->emit($app->resolve($request)->toPsr7());
