<?php
namespace Tmakinde\ExpenseTracker\Facade;

use Illuminate\Support\Facades\Facade;
use Tmakinde\ExpenseTracker\CategoryManager;

class Category extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CategoryManager::class;
    }
}
