<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\OrganizationType;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class DonorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'type'      => ['required', new EnumRule(OrganizationType::class)],
            'hq'        => ['nullable', 'string', 'max:255'],
            'contact'   => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'phone'     => ['required', 'string', 'max:255'],
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
