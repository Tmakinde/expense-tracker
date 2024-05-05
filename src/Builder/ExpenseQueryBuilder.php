<?php

namespace Tmakinde\ExpenseTracker\Builder;

use Tmakinde\ExpenseTracker\Contract\ExpenseQueryBuilderInterface;
use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Contract\ExpenseInterface;
use Tmakinde\ExpenseTracker\Model\Expense;
use Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ExpenseQueryBuilder implements ExpenseQueryBuilderInterface
{

    public function __construct(protected $user)
    {
        $this->model = $this->resolveModel();
        $this->user = $user;
    }

    private function resolveModel() : Builder
    {
        return Expense::where('user_id', $this->user->id);
    }

    public function whereCategory(Model $category) : self
    {
        $this->model = $this->model->where('category_id', $category->id);
        return $this;
    }

    public function between(Datetime $dateFrom, DateTime $dateTo) : self
    {
        $this->model = $this->model->whereBetween('created_at', [$dateFrom, $dateTo]);
        return $this;
    }

    public function groupByCategory() : Collection
    {
        $this->model = $this->model->groupBy('category');
        return $this->get();
    }

    public function get() : Collection
    {
        return $this->model->get();
    }
}
