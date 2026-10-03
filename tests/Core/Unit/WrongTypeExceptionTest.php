<?php

use RlyBadBB\Core\Exceptions\WrongTypeException;

test('it creates correct exception for string', function () {
    $variable = '$test';
    $actualType = gettype(5);

    $exception = WrongTypeException::forString($variable, $actualType);

    expect($exception->variable)->toBe($variable);
    expect($exception->actualType)->toBe($actualType);
    expect($exception->expectedTypes)->toBe(['string']);
    expect($exception->getMessage())->toBe("$variable needs to be of type string, $actualType given.");
});

test('it creates correct exception for multiple types', function () {
    $variable = '$test';
    $actualType = gettype(5);
    $expectedTypes = [gettype($variable), gettype(true)];

    $expected = implode(', ', $expectedTypes);
    $message = sprintf('%s needs to be one of the following types: %s. %s given.', $variable, $expected, $actualType);

    $exception = WrongTypeException::forMultipleTypes($variable, $actualType, $expectedTypes);

    expect($exception->variable)->toBe($variable);
    expect($exception->actualType)->toBe($actualType);
    expect($exception->expectedTypes)->toBe($expectedTypes);
    expect($exception->getMessage())->toBe($message);
});
