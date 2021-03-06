<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'      => ['required', 'string', 'max:255'],
            'grantees.*' => ['required', 'exists:grantees,id'],
            'amount'     => ['required', 'numeric'],
            'start_date' => ['required', 'date_format:Y-m-d', 'before:end_date'],
            'end_date'   => ['required', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }
}
