<?php

use RlyBadBB\Core\Exceptions\ActionNotFoundException;

test('it creates correct exception', function () {
    $action = 'test';
    $class = 'Test';
    $exception = ActionNotFoundException::forAction($action, $class);

    expect($exception->action)->toBe($action);
    expect($exception->class)->toBe($class);
    expect($exception->getCode())->toBe(404);
    expect($exception->getMessage())->toBe("Action $action not found on $class.");
});
