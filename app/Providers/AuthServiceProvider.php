<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\UserRole;
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
        Gate::before(fn ($user) => $user->role->equals(UserRole::admin()) ?: null);

        Inertia::share('auth', function () {
            if (! Auth::check()) {
                return null;
            }

            $user = Auth::user();

            return [
                'id'           => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'avatar'       => $user->avatar,
                'role'         => $user->role,
                'permissions'  => $user->all_permissions,
                'organization' => $user->isAdmin()
                    ? ['id' => null, 'name' => __('dashboard.role.admin')]
                    : $user->organization->only('id', 'name'),

            ];
        });
    }
}
