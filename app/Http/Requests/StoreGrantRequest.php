<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGrantRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => ['required', 'string'],
            'area'       => ['required', 'exists:focus_areas,id'],
            'grantees.*' => ['required', 'exists:grantees,id'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date'   => ['required', 'date_format:Y-m-d'],
            'amount'     => ['required', 'numeric'],
            'currency'   => ['required', Rule::in(config('money.currencies.iso'))],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'amount' => floatval($this->amount),
        ]);
    }
}
