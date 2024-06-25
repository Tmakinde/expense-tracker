<?php
namespace Tmakinde\ExpenseTracker\Exceptions;

use TypeError;

class InvalidTypeException extends TypeError
{
    public static function LogError(string $message) : self
    {
        return new self($message);
    }
}
