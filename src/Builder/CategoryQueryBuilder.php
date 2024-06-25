<?php

namespace Tmakinde\ExpenseTracker\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Tmakinde\ExpenseTracker\Contract\CategoryQueryBuilderInterface;
use Tmakinde\ExpenseTracker\Exceptions\DuplicateTypeException;
use Tmakinde\ExpenseTracker\Exceptions\InvalidModelException;
use Tmakinde\ExpenseTracker\Model\Category;

class CategoryQueryBuilder implements CategoryQueryBuilderInterface
{
    protected $model;

    public function __construct(protected $user)
    {
        $this->user = $user;
        $this->model = $this->resolveModel();
    }

    private function resolveModel() : Builder
    {
        return Category::where('user_id', $this->user->id);
    }

    public function create(array $data) : Category
    {
        $category = $this->model->where('name', $data['name'])->first();
        if ($category) {
            throw DuplicateTypeException::LogError('Category already exists');
        }
        try {
            return $this->model->create($data);
        } catch (\Throwable $ex) {
            throw InvalidModelException::LogError($ex->getMessage());
        }
    }

    public function active() : self
    {
        $this->model = $this->model->where('is_active', 1);
        return $this;
    }

    public function inactive() : self
    {
        $this->model = $this->model->where('is_active', 0);
        return $this;
    }

    public function get() : Collection
    {
        return $this->model->get();
    }

}
