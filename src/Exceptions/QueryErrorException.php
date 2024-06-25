<?php
namespace Tmakinde\ExpenseTracker\Exceptions;

use ErrorException;

class QueryErrorException extends ErrorException
{
    public static function LogError(string $message) : self
    {
        return new self($message);
    }
}
