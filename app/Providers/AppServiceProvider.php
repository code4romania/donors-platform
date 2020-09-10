<?php

declare(strict_types=1);

namespace App\Providers;

use App\Observers\ActivityObserver;
use App\Services\MoneyWithoutDecimalsFormatter;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Request;
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
            ->each(fn ($model) => app($model)::observe(ActivityObserver::class));

        $this->registerMoneyMacros();
    }

    private function registerInertia(): void
    {
        Inertia::version(fn () => md5_file(public_path('mix-manifest.json')));

        Inertia::share([
            'locale'  => fn () => app()->getLocale(),
            'locales' => fn () => config('translatable.locale_names'),
            'route'   => fn () => Route::currentRouteName(),

            'sort'    => fn () => Request::all('order', 'direction'),
            'search'  => fn () => Request::input('search'),
            'filters' => fn () => Request::all('domain', 'donor', 'manager'),

            'currencies' => fn () => config('money.currencies.iso', []),

            'flash' => function () {
                return [
                    'success' => Session::get('success'),
                    'error'   => Session::get('error'),
                ];
            },
        ]);
    }

    private function registerMoneyMacros(): void
    {
        Money::macro('formatWithoutDecimals', function (): string {
            return $this->formatByFormatter(new MoneyWithoutDecimalsFormatter());
        });

        Money::macro('toInteger', function (): int {
            return (int) $this->format(null, null, null);
        });
    }
}
