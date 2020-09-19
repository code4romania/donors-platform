<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $permissions = collect(json_decode($this->permissions, true));

        dd($permissions);

        $this->merge([
            'permissions' => $permissions,
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
            'name'          => ['required', 'string'],
            'email'         => ['required', 'email'],
            'role'          => ['required', 'string', 'exists:roles,name'],
            'permissions.*' => ['exists:permissions,name'],
        ];
    }
}
