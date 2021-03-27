<?php

namespace App\Providers;

use DDDCodeTest\Backoffice\Budgets\Domain\BudgetRepository;
use DDDCodeTest\Backoffice\Budgets\Infrastructure\Persistence\EloquentBudgetRepository;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineRepository;
use DDDCodeTest\Backoffice\BudgetsLines\Infrastructure\Persistence\EloquentBudgetLineRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            BudgetRepository::class,
            EloquentBudgetRepository::class
        );
        $this->app->bind(
            LineRepository::class,
            EloquentBudgetLineRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
