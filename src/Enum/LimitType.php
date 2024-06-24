<?php
namespace Tmakinde\ExpenseTracker\Enum;

abstract class LimitType
{
    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const MONTHLY = 'monthly';
    public const YEARLY = 'yearly';

    public static function getAllTypes() : array
    {
        return [
            static::DAILY, static::WEEKLY, static::MONTHLY, static::YEARLY
        ];
    }
}
