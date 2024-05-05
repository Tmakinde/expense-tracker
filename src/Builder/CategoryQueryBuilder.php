<?php

namespace Tmakinde\ExpenseTracker\Builder;

use Illuminate\Database\Eloquent\Collection;
use Tmakinde\ExpenseTracker\Contract\CategoryQueryBuilderInterface;
use Tmakinde\ExpenseTracker\Model\Category;

class CategoryQueryBuilder implements CategoryQueryBuilderInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    private function resolveModel() : Category
    {
        return Category::class;
    }

    public function create(array $data) : Category
    {
        return $this->model->create($data);
    }

    public function get() : Collection
    {
        return $this->model->get();
    }

}
