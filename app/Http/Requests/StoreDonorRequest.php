<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('manage donors');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => ['required', 'string'],
            'type'    => ['required', 'string'],
            'hq'      => ['nullable', 'string'],
            'contact' => ['required', 'string'],
            'email'   => ['required', 'email'],
            'phone'   => ['required', 'string'],
            'areas.*' => ['required', 'exists:focus_areas,id'],
            'logo'    => [
                'sometimes',
                'image',
                'mimes:jpeg,png,gif',
                'dimensions:min_width=300,min_height=300',
                'max:' . config('media-library.max_file_size'),
            ],
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
            'areas' => array_filter($this->areas),
        ]);
    }
}
