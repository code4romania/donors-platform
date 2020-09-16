<?php

declare(strict_types=1);

namespace App\Scopes;

use App\Models\ExchangeRate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

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
        $query->addSelect(
            collect(config('money.currencies.iso'))
                ->mapWithKeys(fn ($currency) => $this->exchangeRateSubquery($currency, $model->getTable()))
                ->toArray()
        );
    }

    protected function exchangeRateSubQuery(string $currency, string $table): array
    {
        return [
            "rate_$currency" => ExchangeRate::select('rate')
                ->whereColumn('date', '<=', DB::raw("LAST_DAY(`$table`.`start_date`)"))
                ->whereColumn('currency_from', "$table.currency")
                ->where('currency_to', $currency)
                ->latest('date')
                ->take(1),
        ];
    }
}
