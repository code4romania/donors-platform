<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\ExchangeRate;
use Cknow\Money\Money;
use Illuminate\Support\Carbon;

trait Exchangeable
{
    public function exchangeAmounts($amounts, $currency): Money
    {
        return collect($amounts)
            ->map(fn ($item) =>  ExchangeRate::convert(
                Money::parseByDecimal($item->amount, $item->currency),
                $currency,
                Carbon::parse($item->date)
            ))
            ->whenNotEmpty(
                fn ($amounts) => Money::sum(...$amounts),
                fn () => Money::parse(0, $currency),
            );
    }
}
