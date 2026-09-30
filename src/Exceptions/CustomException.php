<?php

declare(strict_types=1);

namespace RlyBadBB\Exceptions;

use Exception;

abstract class CustomException extends Exception implements ExceptionInterface
{
    protected $message = 'Unknown exception';     // Exception message
    /** @var int */
    protected $code    = 0;                       // User-defined exception code
    protected string $file;                       // Source filename of exception
    protected int $line;                          // Source line of exception

    public function __construct(?string $message = null, int $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown ' . get_class($this));
        }
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
}
