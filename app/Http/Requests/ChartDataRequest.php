<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ChartDataRequest extends FormRequest
{
    protected int $cachettl = 60 * 60;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'domains.*' => ['required', Rule::in($this->validDomains())],
            'years.*'   => ['required', Rule::in($this->validYears())],
            'currency'  => ['nullable', Rule::in(config('money.currencies.iso'))],
        ];
    }

    protected function validYears(): array
    {
        return Cache::remember('public-valid-years', $this->cachettl, function () {
            return DB::table('grants')
                ->selectRaw('YEAR(start_date) as year')
                ->distinct()
                ->pluck('year')
                ->toArray();
        });
    }

    public function validDomains(): array
    {
        return Cache::remember('public-valid-domains', $this->cachettl, function () {
            return DB::table('domains')
                ->pluck('id')
                ->toArray();
        });
    }

    protected function failedValidation($validator)
    {
        abort(403);
    }

    protected function passedValidation()
    {
        foreach (['domains', 'years'] as $prop) {
            $this->merge([
                $prop => collect($this->$prop)
                    ->map(fn ($value) => intval($value))
                    ->unique()
                    ->sort()
                    ->values()
                    ->whenNotEmpty(
                        fn ($collection) => $collection->toArray(),
                        fn () => null
                    ),
            ]);
        }
    }
}
