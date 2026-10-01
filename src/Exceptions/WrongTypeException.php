<?php

declare(strict_types=1);

namespace RlyBadBB\Exceptions;

use Throwable;

final class WrongTypeException extends AppException
{
    /**
     * @param string $variable Name of the variable that is of wrong type.
     * @param string $actualType Actual type of the $variable.
     * @param array<int, string> $expectedTypes Type that $variable is allowed to be.
     */
    private function __construct(
        public readonly string $variable,
        public readonly string $actualType,
        public readonly array $expectedTypes,
        string $message,
        int $code = 500,
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            message: $message,
            code: $code,
            previous: $previous,
        );
    }

    /**
     * Factory for when variable should be of type string.
     *
     * @param string $variable Name of the variable that is of wrong type.
     * @param string $actualType Actual type of the $variable.
     *
     * @retuns self
     */
    public static function forString(
        string $variable,
        string $actualType,
        ?Throwable $previous = null,
    ): self {
        return self::forMultipleTypes(
            variable: $variable,
            actualType: $actualType,
            expectedTypes: ['string'],
            previous: $previous,
        );
    }

    /**
     * Factory for when variable should be one of types specified in $types.
     *
     * @param string $variable Name of the variable that is of wrong type.
     * @param string $actualType Actual type of the $variable.
     * @param array<int, string> $expectedTypes Type that $variable is allowed to be.
     *
     * @retuns self
     */
    public static function forMultipleTypes(
        string $variable,
        string $actualType,
        array $expectedTypes,
        ?Throwable $previous = null,
    ): self {
        $expected = implode(', ', $expectedTypes);

        $message = count($expectedTypes) === 1
            ? sprintf('%s needs to be of type %s, %s given.', $variable, $expected, $actualType)
            : sprintf('%s needs to be one of the following types: %s. %s given.', $variable, $expected, $actualType);

        return new self(
            variable: $variable,
            actualType: $actualType,
            expectedTypes: array_values($expectedTypes),
            message: $message,
            code: 500,
            previous: $previous,
        );
    }
}
