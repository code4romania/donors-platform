<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrantManagerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'string'],
            'hq'        => ['nullable', 'string'],
            'contact'   => ['required', 'string'],
            'email'     => ['required', 'email'],
            'phone'     => ['required', 'string'],
            'domains.*' => ['required', 'exists:domains,id'],
            'logo'      => [
                'nullable',
                'image',
                'mimes:jpeg,png,gif',
                'dimensions:min_width=300,min_height=300',
                'max:' . config('media-library.max_file_size'),
            ],
        ];
    }
}
