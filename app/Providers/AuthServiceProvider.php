<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Templates;
use App\Policies\UserPolicy;
use App\Services\AuthService;
use App\Services\Impl\AuthServiceImpl;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        app()->singleton(AuthService::class, AuthServiceImpl::class);
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }

    public function provides()
    {
        return [AuthService::class];
    }
}
