<?php

use RlyBadBB\Core\Exceptions\ControllerNotFoundException;

test('it creates correct exception', function () {
    $class = 'Test';
    $exception = ControllerNotFoundException::forClass($class);

    expect($exception->class)->toBe('Test');
    expect($exception->getCode())->toBe(404);
    expect($exception->getMessage())->toBe("Controller $class not found.");
});
