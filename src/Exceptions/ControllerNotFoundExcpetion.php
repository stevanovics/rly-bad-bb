<?php

declare(strict_types=1);

namespace RlyBadBB\Exceptions;

use Throwable;

final class ControllerNotFoundException extends AppException
{
    public function __construct(
        public readonly string $class,
        string $message = "",
        int $code = 0,
        Throwable|null $previous = null,
    ) {
        return parent::__construct(
            $message,
            $code,
            $previous,
        );
    }
    /**
     * Factory method to construct the exception for not found class.
     *
     * @param string $class Controller class that was not found.
     * @param ?Throwable $previous The previous throwable used for the exception chaining,
     *     default null.
     *
     * @return self
     */
    public static function forClass(string $class, ?Throwable $previous = null): self
    {
        return new self(
            class: $class,
            message: "Controller $class not found.",
            code: 404,
            previous: $previous
        );
    }
}
