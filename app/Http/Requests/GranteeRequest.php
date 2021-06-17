<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\TaxIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GranteeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => ['required', 'string', 'max:255'],
            'without_tax_id' => ['boolean', 'required_without:tax_id'],
            'tax_id' => [
                'required_without:without_tax_id',
                new TaxIdRule,
                Rule::unique('grantees', 'tax_id')->ignore($this->grantee),
            ],
        ];
    }
}
