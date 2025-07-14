<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentCms\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Third-party policies
        Gate::policy(\TomatoPHP\FilamentCms\Models\Category::class, \App\Policies\CategoryPolicy::class);
        Gate::policy(\TomatoPHP\FilamentCms\Models\Post::class, \App\Policies\PostPolicy::class);
        Gate::policy(\TomatoPHP\FilamentMenus\Models\Menu::class, \App\Policies\MenuPolicy::class);
    }
}
