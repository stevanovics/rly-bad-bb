<?php

use RlyBadBB\Routing\EntryPoint;

require __DIR__ . '/../vendor/autoload.php';

$routes = require __DIR__ . '/../config/routes.php';

$entry = new EntryPoint($routes);

$entry->resolve();
