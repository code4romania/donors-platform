<?php

declare(strict_types=1);

namespace App\Services;

use Cknow\Money\Money;
use Illuminate\Support\Facades\Request;
use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exchange\FixedExchange;

class Exchange
{
    public static function sumForCurrency($amounts, ?string $currency_to = null, string $column = 'amount'): Money
    {
        $currency_to ??= Request::input('currency', config('money.defaultCurrency'));

        return collect($amounts)
            ->map(fn ($item) => self::convert($item->$column, $currency_to, $item->rate))
            ->whenNotEmpty(
                fn ($amounts) => Money::sum(...$amounts),
                fn () => Money::parse(0, $currency_to),
            );
    }

    public static function convert(Money $amount, string $currency_to, ?string $rate): Money
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
            ])
        );

        return Money::convert(
            $converter->convert($amount->getMoney(), $currency_to)
        );
    }
}
