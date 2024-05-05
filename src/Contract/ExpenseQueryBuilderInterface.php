<?php
namespace Tmakinde\ExpenseTracker\Contract;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Contract\ExpenseInterface;
use Illuminate\Database\Eloquent\Collection;


interface ExpenseQueryBuilderInterface {

    public function whereCategory(Model $category) : self;

    public function between(Datetime $dateFrom, DateTime $dateTo) : self;

    public function groupByCategory() : Collection;

    public function get() : Collection;
}
