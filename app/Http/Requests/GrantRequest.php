<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\DonorContributionsMatchGrantValue;
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
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return RuleFactory::make([
            '%name%'              => ['required', 'string', 'max:255'],
            '%description%'       => ['nullable', 'string'],
            'primary_domain'      => ['required', 'exists:domains,id'],
            'secondary_domains.*' => ['required', 'exists:domains,id'],
            'project_count'       => ['required', 'numeric'],
            'start_date'          => ['required', 'date_format:Y-m-d', 'before:end_date', 'after_or_equal:2007-01-01'],
            'end_date'            => ['required', 'date_format:Y-m-d', 'after:start_date'],
            'amount'              => ['required', 'numeric'],
            'donors'              => ['required', new DonorContributionsMatchGrantValue($this->input('amount'))],
            'donors.*.id'         => ['required', 'exists:donors,id'],
            'donors.*.amount'     => ['required', 'numeric'],
            'currency'            => ['required', Rule::in(config('money.currencies.iso'))],
            'manager'             => ['nullable', 'exists:grant_managers,id'],
            'regranting_amount'   => ['nullable', 'numeric', 'lte:amount'],
            'matching'            => ['nullable', 'boolean'],
        ]);
    }
}
