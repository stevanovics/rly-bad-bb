<?php

declare(strict_types=1);

use RlyBadBB\Controllers\HomeController;

return [
    'GET' => [
        '/' => [HomeController::class, 'index'],
    ],
];
