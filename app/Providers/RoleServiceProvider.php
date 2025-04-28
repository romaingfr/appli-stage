<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Role;

class RoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Role::class, function ($app) {
            return new Role();
        });
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(database_path('migrations'));
    }
}
