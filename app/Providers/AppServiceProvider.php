<?php

namespace App\Providers;

use App\Actions\ImportDatesAction;
use App\Actions\ImportDatesActionInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImportDatesActionInterface::class, ImportDatesAction::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
