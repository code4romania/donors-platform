<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'user' => \App\Models\User::class,
        ]);

        $this->registerInertia();
    }

    private function registerInertia(): void
    {
        Inertia::version(fn () => md5_file(public_path('assets/mix-manifest.json')));

        Inertia::setRootView('layouts.app');

        Inertia::share([
            'locale' => fn () => app()->getLocale(),

            'auth' => function () {
                return [
                    'user' => Auth::user() ? [
                        'id'    => Auth::user()->id,
                        'name'  => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'role'  => Auth::user()->role,
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
