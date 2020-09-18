<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * If specified, this namespace is automatically applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            Route::prefix('dashboard')
                ->domain(config('dashboard.url'))
                ->prefix(config('dashboard.path'))
                ->middleware(['web', 'dashboard'])
                ->group(base_path('routes/dashboard.php'));

            Route::middleware('web')
                ->domain(str_replace(['http://', 'https://'], '', config('app.url')))
                ->group(base_path('routes/web.php'));
        });
    }
}
