<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GrantRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'amount'            => floatval($this->amount),
            'regranting_amount' => floatval($this->regranting_amount),
        ]);

        $this->merge(
            collect(config('translatable.locales'))
                ->mapwithKeys(fn ($locale) => [$locale => json_decode($this->$locale, true)])
                ->toArray(),
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return RuleFactory::make([
            '%name%'              => ['required', 'string'],
            '%description%'       => ['nullable', 'string'],
            'primary_domain'      => ['required', 'exists:domains,id'],
            'secondary_domains.*' => ['required', 'exists:domains,id'],
            'project_count'       => ['required', 'numeric'],
            'start_date'          => ['required', 'date_format:Y-m-d', 'before:end_date', 'after_or_equal:2007-01-01'],
            'end_date'            => ['required', 'date_format:Y-m-d', 'after:start_date'],
            'amount'              => ['required', 'numeric'],
            'donors.*'            => ['required', 'exists:donors,id'],
            'currency'            => ['required', Rule::in(config('money.currencies.iso'))],
            'manager'             => ['nullable', 'exists:grant_managers,id'],
            'regranting_amount'   => ['nullable', 'lte:amount'],
            'matching'            => ['nullable', 'boolean'],
        ]);
    }
}
