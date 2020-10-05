<?php

declare(strict_types=1);

namespace App\Traits;

use Cknow\Money\Money;
use Illuminate\Support\Facades\Request;
use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exchange\FixedExchange;

trait HasExchangeRates
{
    public function sumForCurrency($amounts, ?string $currency_to = null): Money
    {
        $currency_to ??= Request::input('currency', config('money.defaultCurrency'));

        return collect($amounts)
            ->map(fn ($item) => $this->convert($item->amount, $currency_to, $item->rate))
            ->whenNotEmpty(
                fn ($amounts) => Money::sum(...$amounts),
                fn () => Money::parse(0, $currency_to),
            );
    }

    public function convert(Money $amount, string $currency_to, ?string $rate): Money
    {
        $currency_from = $amount->getCurrency();
        $currency_to = new Currency($currency_to);

        if ($currency_from->equals($currency_to) || $rate === null) {
            return $amount;
        }

        $converter = new Converter(
            new ISOCurrencies(),
            new FixedExchange([
                "$currency_from" => ["$currency_to" => $rate],
            ]));

        return Money::convert(
            $converter->convert($amount->getMoney(), $currency_to)
        );
    }
}
