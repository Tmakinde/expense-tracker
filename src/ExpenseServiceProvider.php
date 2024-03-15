<?php

namespace Tmakinde\ExpenseTracker;

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

    }
}
