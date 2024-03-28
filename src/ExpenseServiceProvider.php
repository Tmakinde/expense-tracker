<?php

namespace Tmakinde\ExpenseTracker;
use Tmakinde\ExpenseTracker\ExpenseManager;

use Illuminate\Support\ServiceProvider;

class ExpenseServiceProvider extends ServiceProvider {
    public function boot() : void
    {
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);
    }

    public function register() : void
    {
        $this->app->bind(ExpenseManager::class, fn(Application $app) => new ExpenseManager($app));
    }
}
