<?php

namespace App\Providers;

use App\Models\Site;
use App\Models\Client;
use App\Policies\SitePolicy;
use App\Policies\ClientPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Site::class => SitePolicy::class,
        Client::class => ClientPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return true; // Autorise temporairement toutes les actions
        });
    }
}
