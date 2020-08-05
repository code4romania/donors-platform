<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
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
        Relation::morphMap([
            'donor' => \App\Models\Donor::class,
            'user'  => \App\Models\User::class,
        ]);
    }

    private function registerInertia(): void
    {
        Inertia::version(fn () => md5_file(public_path('assets/mix-manifest.json')));

        Inertia::setRootView('layouts.app');

        Inertia::share([
            'locale' => fn () => app()->getLocale(),
            'locales' => fn () => config('translatable.locale_names'),

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
        ]);
    }
}
