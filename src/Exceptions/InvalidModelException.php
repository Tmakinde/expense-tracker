<?php

namespace Tmakinde\ExpenseTracker\Exceptions;

use Exception;

class InvalidModelException extends Exception
{
    public static function LogError(string $message) : self
    {
        return new self($message);
    }
}
