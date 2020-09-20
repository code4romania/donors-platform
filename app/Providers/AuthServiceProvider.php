<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "admin" role all permissions
        Gate::before(fn ($user) => $user->hasRole('admin') ?: null);

        Inertia::share('auth', fn () => Auth::check() ? [
            'id'          => Auth::user()->id,
            'name'        => Auth::user()->name,
            'email'       => Auth::user()->email,
            'avatar'      => Auth::user()->avatar,
            'role'        => Auth::user()->role,
            'permissions' => Auth::user()->all_permissions,
        ] : null);
    }
}
