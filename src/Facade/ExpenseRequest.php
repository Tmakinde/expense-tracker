<?php
namespace Tmakinde\ExpenseTracker\Facade;

use Illuminate\Support\Facades\Facade;
use Tmakinde\ExpenseTracker\ExpenseManager;

class ExpenseRequest extends Facade
{

    protected static function getFacadeAccessor()
    {
        return ExpenseManager::class;
    }
}
