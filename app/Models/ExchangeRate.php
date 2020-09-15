<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Cknow\Money\Money;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exchange\FixedExchange;

class ExchangeRate extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'currency_from', 'currency_to', 'rate', 'date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'rate' => 'float',
        'date' => 'date',
    ];

    public function setCurrencyFromAttribute($value)
    {
        $this->attributes['currency_from'] = Str::upper($value);
    }

    public function setCurrencyToAttribute($value)
    {
        $this->attributes['currency_to'] = Str::upper($value);
    }

    public function scopeConvert(Builder $query, Money $amount, string $currency_to, Carbon $date): Money
    {
        $currency_from = $amount->getCurrency();
        $currency_to = new Currency($currency_to);

        if ($currency_from->equals($currency_to)) {
            return $amount;
        }

        $exchange = $query->latest('date')
            ->whereDate('date', '<=', $date->endOfMonth())
            ->where('currency_from', $currency_from)
            ->where('currency_to', $currency_to)
            ->first();

        if (! $exchange) {
            throw new Exception("Unable to find exchange rate for {$currency_from}/{$currency_to}");
        }

        $converter = new Converter(
            new ISOCurrencies(),
            new FixedExchange([
                "$currency_from" => ["$currency_to" => $exchange->rate],
            ]));

        return Money::convert(
            $converter->convert($amount->getMoney(), $currency_to)
        );
    }
}
