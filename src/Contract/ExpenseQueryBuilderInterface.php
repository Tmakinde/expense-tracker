<?php
namespace Tmakinde\ExpenseTracker\Contract;
use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Contract\ExpenseInterface;

interface ExpenseQueryBuilderInterface {
    public function whereCategory(Model $category) : self;

    public function between(string $dateFrom, string $dateTo) : self;

    public function groupByCategory() : self;

    public function get() : ExpenseInterface;
}
