<?php

declare(strict_types=1);

namespace RlyBadBB\Exceptions;

interface ExceptionInterface
{
    /* Protected methods inherited from Exception class */
    public function getMessage(): string;         // Exception message
    /** @return int */
    public function getCode();                    // User-defined Exception code
    public function getFile(): string;            // Source filename
    public function getLine(): int;               // Source line
    /** @return array<int, string> */
    public function getTrace(): array;            // An array of the backtrace()
    public function getTraceAsString(): string;   // Formated string of trace

    /* Overrideable methods inherited from Exception class */
    public function __toString(): string;         // formated string for display
    public function __construct(?string $message = null, int $code = 0);
}
