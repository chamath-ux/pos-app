<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;

use Illuminate\Support\ServiceProvider;
use App\Services\CheckPermissionService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
          // Register the custom permission service as a singleton
          $this->app->singleton(CheckPermissionService::class, function ($app) {
            return new CheckPermissionService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
