<?php

declare(strict_types=1);

namespace RlyBadBB\Core\Exceptions;

use RuntimeException;

/**
 * Base class for all custom exceptions.
 */
abstract class AppException extends RuntimeException implements ExceptionInterface
{
}
