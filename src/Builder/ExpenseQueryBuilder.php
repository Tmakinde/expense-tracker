<?php

namespace Tmakinde\ExpenseTracker\Builder;

use Tmakinde\ExpenseTracker\Contract\ExpenseQueryBuilderInterface;
use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Contract\ExpenseInterface;
use Tmakinde\ExpenseTracker\Model\Expense;
use Carbon;

class ExpenseQueryBuilder implements ExpenseQueryBuilderInterface
{

    public function __construct(protected Application $app, protected $config, protected $model)
    {
        $this->app = $app;
        $this->config = $app['config'];
        $this->model = $this->resolveModel();
    }

    private function resolveModel() : ExpenseInterface
    {
        return new Expense()->where('user_id', $this->app->expenseUser);
    }

    public function whereCategory(Model $category) : self
    {
        $this->model = $this->model->where('category_id', $category->id);
        return $this;
    }

    public function between(string $dateFrom, string $dateTo) : self
    {
        $this->model = $this->model->filter(function($item) use($dateTo, $dateFrom) {
            if (Carbon::now()->between($dateFrom, $dateTo)) {
                return $item;
            }
        });

        return $this;
    }

    public function groupByCategory() : self
    {
        $this->model = $this->model->groupBy('category');
        return $this;
    }

    public function get() : ExpenseInterface
    {
        return $this->model->get();
    }
}
