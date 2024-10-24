<?php

namespace Tmakinde\ExpenseTracker\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Tmakinde\ExpenseTracker\Contract\CategoryQueryBuilderInterface;

class CategoryQueryBuilder implements CategoryQueryBuilderInterface
{
    protected $model;

    public function __construct(protected $user)
    {
        $this->user = $user;
        $this->resolveModel();
    }

    private function resolveModel()
    {
        $this->model = $this->user->categories();
        return $this->model;
    }

    public function whereLimitType(string $type) : self
    {
        $this->model = $this->model->whereHas('limit', function($query) use ($type) {
            $query->where('limit_type', $type);
        });
        return $this;
    }

    public function whereLimitAmountBetween(int $min, int $max): self
    {
        $this->model = $this->model->whereHas('limit', function($query) use ($min, $max) {
            $query->whereBetween('amount', [$min, $max]);
        });
        return $this;
    }

    public function get() : Collection
    {
        return $this->model->get();
    }

}
