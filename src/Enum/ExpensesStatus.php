<?php
namespace Tmakinde\ExpenseTracker\Enum;

abstract class ExpensesStatus
{
    public const PENDING = 'pending';
    public const PAID = 'paid';
    public const UNDERPAID = 'underpaid';
    public const OVERPAID = 'overpaid';

    public function getAllStatuses() : array
    {
        return [
            static::OVERPAID, static::UNDERPAID, static::PAID, static::PENDING
        ];
    }
}
