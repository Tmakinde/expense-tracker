<?php

namespace Tmakinde\ExpenseTracker;

use Tmakinde\ExpenseTracker\Enum\ExpensesStatus;
use Tmakinde\ExpenseTracker\Contract\ExpenseInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Builder\ExpenseQueryBuilder;

class ExpenseManager {

    public function __construct(protected Application $app)
    {
        $this->app = $app;
    }

    public function for(Model $user) : ExpenseQueryBuilder
    {
        $this->app->expenseUser = $user;
        return $this->app[ExpenseQueryBuilder::class];
    }
}
