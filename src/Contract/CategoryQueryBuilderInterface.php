<?php
namespace Tmakinde\ExpenseTracker\Contract;

use Illuminate\Database\Eloquent\Collection;
use Tmakinde\ExpenseTracker\Model\Category;

interface CategoryQueryBuilderInterface {

    public function get() : Collection;
    public function whereLimitType(string $type) : CategoryQueryBuilderInterface;
    public function whereLimitAmountBetween(int $min, int $max) : CategoryQueryBuilderInterface;
}
