<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TaxIdRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (! is_int($value)) {
            $value = (int) preg_replace('/\D/', '', (string) $value);
        }

        if ($value < 10 || $value > 999999999) {
            return false;
        }

        $key = 753217532;

        $control = $value % 10;
        $value = (int) ($value / 10);

        $t = 0;
        while ($value > 0) {
            $t += ($value % 10) * ($key % 10);
            $value = intdiv($value, 10);
            $key = intdiv($key, 10);
        }

        $check = $t * 10 % 11;

        if ($check == 10) {
            $check = 0;
        }

        return $control === $check;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.tax_id');
    }
}
