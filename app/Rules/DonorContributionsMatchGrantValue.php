<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DonorContributionsMatchGrantValue implements Rule
{
    public float $grantValue;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($grantValue)
    {
        $this->grantValue = (float) $grantValue;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->grantValue === (float) collect($value)->pluck('amount')->sum();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.donor_contributions_mismatch');
    }
}
