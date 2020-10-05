<?php

declare(strict_types=1);

namespace App\Scopes;

use App\Models\ExchangeRate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class WithExchangeRatesScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Illuminate\Database\Eloquent\Model   $model
     * @return void
     */
    public function apply(Builder $query, Model $model)
    {
        $query->addSelect([
            'rate' => ExchangeRate::select('rate')
                ->whereColumn('date', '<=', DB::raw('LAST_DAY(`start_date`)'))
                ->whereColumn('currency_from', 'currency')
                ->where('currency_to', Request::input('currency', config('money.defaultCurrency')))
                ->latest('date')
                ->take(1),
        ]);
    }
}
