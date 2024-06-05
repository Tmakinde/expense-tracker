<?php

namespace Tmakinde\ExpenseTracker;
use Tmakinde\ExpenseTracker\ExpenseManager;

use Illuminate\Support\ServiceProvider;

class ExpenseServiceProvider extends ServiceProvider {
    public function boot() : void
    {
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations/expenses'),
        ], 'expenses-migrations');

        $this->publishes([
            __DIR__ . '/config' => config_path('config/expenses')
        ], 'expenses-config');
    }

    public function register() : void
    {
        $this->app->bind(ExpenseManager::class, fn(Application $app) => new ExpenseManager($app));
    }
}
