<?php

declare(strict_types=1);

namespace RlyBadBB\Controllers;

use RlyBadBB\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return (Response::fromData('Hello World'));
    }
}
