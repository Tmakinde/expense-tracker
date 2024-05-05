<?php
namespace Tmakinde\ExpenseTracker\Facade;

use Illuminate\Support\Facades\Facade;
use Tmakinde\ExpenseTracker\Builder\CategoryQueryBuilder;

class Category extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CategoryQueryBuilder::class;
    }
}
