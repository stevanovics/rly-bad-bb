<?php

declare(strict_types=1);

namespace RlyBadBB\Controllers;

use RlyBadBB\Core\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return (Response::html('Hello World'));
    }
}
