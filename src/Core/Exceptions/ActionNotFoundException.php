<?php

declare(strict_types=1);

namespace RlyBadBB\Core\Exceptions;

use Throwable;

final class ActionNotFoundException extends AppException
{
    public function __construct(
        public readonly string $action,
        public readonly string $class,
        string $message = "",
        int $code = 404,
        Throwable|null $previous = null,
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
        );
    }
    /**
     * Factory method to construct the exception for not found action.
     *
     * @param string $action Action that was not found.
     * @param string $class Controller class that action was supposed to be on.
     * @param ?Throwable $previous The previous throwable used for the exception chaining,
     *     default null.
     *
     * @return self
     */
    public static function forAction(string $action, string $class, ?Throwable $previous = null): self
    {
        return new self(
            action: $action,
            class: $class,
            message: "Action $action not found on $class.",
            code: 404,
            previous: $previous
        );
    }
}
