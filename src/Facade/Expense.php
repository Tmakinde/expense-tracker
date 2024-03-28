<?php
namespace Tmakinde\ExpenseTracker\Facade;

use Illuminate\Support\Facades\Facade;
use Tmakinde\ExpenseTracker\ExpenseManager;

class Expense extends Facade
{

    protected static function getFacadeAccessor()
    {
        return ExpenseManager::class;
    }
}
