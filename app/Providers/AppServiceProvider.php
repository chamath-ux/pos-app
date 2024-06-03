<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;

use App\Services\AuthService;
use App\Services\RoleService;
use App\Services\UserService;
use App\Observers\UserObserver;
use App\Services\ProductService;
use App\Observers\ProductObserver;
use App\Services\PermissionService;
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

        $this->app->singleton(PermissionService::class, function ($app) {
            return new PermissionService();
        });

        $this->app->singleton(RoleService::class, function ($app) {
            return new RoleService();
        });

        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });

        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Product::observe(ProductObserver::class);
    }
}
