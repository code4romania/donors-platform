<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\TaxIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GranteeRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'tax_id' => $this->tax_id !== null
                ? preg_replace('/\D/', '', $this->tax_id)
                : null,
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
            'name'   => ['required', 'string', 'max:255'],
            'tax_id' => [
                'nullable',
                'string',
                new TaxIdRule,
                Rule::unique('grantees', 'tax_id')->ignore($this->grantee),
            ],
        ];
    }
}
