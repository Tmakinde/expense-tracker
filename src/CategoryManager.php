<?php

namespace Tmakinde\ExpenseTracker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Foundation\Application;
use Tmakinde\ExpenseTracker\Builder\CategoryQueryBuilder;


class CategoryManager
{
    public function __construct(protected Application $app)
    {
        $this->app = $app;
    }

    public function for(Model $user) : CategoryQueryBuilder
    {
        return $this->app->makeWith(CategoryQueryBuilder::class,
            [
                'user' => $user
            ]
        );
    }
}
