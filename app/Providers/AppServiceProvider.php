<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /** @var string[] */
    protected $morphMap = [
        'domain'     => \App\Models\Domain::class,
        'donor'      => \App\Models\Donor::class,
        'grant'      => \App\Models\Grant::class,
        'grantee'    => \App\Models\Grantee::class,
        'manager'    => \App\Models\GrantManager::class,
        'project'    => \App\Models\Project::class,
        'user'       => \App\Models\User::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInertia();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap($this->morphMap);

        collect($this->morphMap)
            ->each(fn ($model) => app($model)::observe(\App\Observers\ActivityObserver::class));
    }

    private function registerInertia(): void
    {
        Inertia::version(fn () => md5_file(public_path('mix-manifest.json')));

        Inertia::share([
            'locale'  => fn () => app()->getLocale(),
            'locales' => fn () => config('translatable.locale_names'),
            'route'   => fn () => Route::currentRouteName(),

            'auth' => function () {
                return [
                    'user' => Auth::user() ? [
                        'id'          => Auth::user()->id,
                        'name'        => Auth::user()->name,
                        'email'       => Auth::user()->email,
                        'roles'       => Auth::user()->role_name,
                        'permissions' => Auth::user()->getAllPermissions()->pluck('name'),
                    ] : null,
                ];
            },

            'flash' => function () {
                return [
                    'success' => Session::get('success'),
                    'error'   => Session::get('error'),
                ];
            },

            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },

            'currencies' => fn () => config('money.currencies.iso', []),
        ]);
    }
}
