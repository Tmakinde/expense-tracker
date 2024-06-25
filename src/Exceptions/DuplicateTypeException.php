<?php

namespace Tmakinde\ExpenseTracker\Exceptions;

use RuntimeException;

class DuplicateTypeException extends RuntimeException
{
    public static function LogError(string $message) : self
    {
        return new self($message);
    }
}
