<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Domain;
use App\Observers\DomainObserver;
use App\Services\MoneyWithoutDecimalsFormatter;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\ServiceProvider;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap($this->morphMap);

        $this->registerMoneyMacros();

        $this->registerBuilderMacros();

        Domain::observe(DomainObserver::class);
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

    private function registerBuilderMacros(): void
    {
        Builder::macro('scoped', function ($scope, ...$parameters) {
            /** @var Builder $query */
            $query = $this;

            if (is_string($scope) && class_exists($scope)) {
                $scope = new $scope(...$parameters);
            }

            if (! $scope instanceof Scope) {
                throw new InvalidArgumentException('$scope must be an instance of Scope');
            }

            $scope->apply($query, $query->getModel());

            return $query;
        });
    }
}
