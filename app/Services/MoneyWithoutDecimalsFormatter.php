<?php

declare(strict_types=1);

namespace App\Services;

use Cknow\Money\Money as CknowMoney;
use Illuminate\Support\Facades\App;
use Money\Currencies;
use Money\Money;
use Money\MoneyFormatter;
use NumberFormatter;

class MoneyWithoutDecimalsFormatter implements MoneyFormatter
{
    private NumberFormatter $formatter;

    private Currencies $currencies;

    public function __construct()
    {
        $this->formatter = new NumberFormatter(App::getLocale(), NumberFormatter::CURRENCY);
        $this->currencies = CknowMoney::getCurrencies();
    }

    public function format(Money $money): string
    {
        $valueBase = $money->getAmount();
        $negative = false;

        if ($valueBase[0] === '-') {
            $negative = true;
            $valueBase = substr($valueBase, 1);
        }

        $subunit = $this->currencies->subunitFor($money->getCurrency());
        $valueLength = strlen($valueBase);

        if ($valueLength > $subunit) {
            $formatted = substr($valueBase, 0, $valueLength - $subunit);
            $decimalDigits = substr($valueBase, $valueLength - $subunit);

            if (strlen($decimalDigits) > 0) {
                $formatted .= '.' . $decimalDigits;
            }
        } else {
            $formatted = '0.' . str_pad('', $subunit - $valueLength, '0') . $valueBase;
        }

        if ($negative === true) {
            $formatted = '-' . $formatted;
        }

        $this->formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);

        return $this->formatter->formatCurrency(floatval($formatted), $money->getCurrency()->getCode());
    }
}
