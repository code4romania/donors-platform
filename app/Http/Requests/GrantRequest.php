<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GrantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('manage grants');
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            '_publish'          => boolval(json_decode($this->_publish ?? false, true)),
            'amount'            => floatval($this->amount),
            'regranting_amount' => floatval($this->regranting_amount),
            'donors'            => array_filter(json_decode($this->donors, true)),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => ['required', 'string'],
            'domain'            => ['required', 'exists:domains,id'],
            'max_grantees'      => ['required', 'numeric'],
            'start_date'        => ['required', 'date_format:Y-m-d', 'before:end_date'],
            'end_date'          => ['required', 'date_format:Y-m-d', 'after:start_date'],
            'amount'            => ['required', 'numeric'],
            'currency'          => ['required', Rule::in(config('money.currencies.iso'))],
            'manager'           => ['nullable', 'exists:grant_managers,id'],
            'regranting_amount' => ['nullable', 'lte:amount'],
            'matching'          => ['nullable', 'boolean'],
        ];
    }
}
