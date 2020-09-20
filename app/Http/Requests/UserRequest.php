<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'permissions' => collect(json_decode($this->permissions, true))
                ->map(function ($actions, $model) {
                    $model = Str::plural($model);

                    return collect($actions)->map(fn ($action) => "$model.$action");
                })
                ->flatten()
                ->toArray(),
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
            'permissions.*' => ['required', 'string', 'exists:permissions,name'],
        ];
    }
}
