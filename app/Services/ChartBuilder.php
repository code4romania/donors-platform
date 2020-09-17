<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class ChartBuilder
{
    public function dashboard(Collection $domains)
    {
        $collection = $domains->map(function ($domain) {
            $domain->grants = $domain->grants
                ->groupBy('year')
                ->sortKeys()
                ->map(fn ($grants) => $domain->sumForCurrency($grants));

            return $domain;
        });

        $years = $collection
            ->pluck('grants')
            ->reject(fn ($grant) => $grant->isEmpty())
            ->map(fn ($grant) => $grant->keys()->first())
            ->unique()
            ->values()
            ->sort();

        return [
            'currency' => Request::input('currency', config('money.defaultCurrency')),
            'labels'   => $years->toArray(),
            'datasets' => $collection
                ->map(function ($domain) use ($years) {
                    return [
                        'label' => $domain->name,
                        'data'  => $years->map(function ($year) use ($domain) {
                            if (! $domain->grants->has($year)) {
                                return 0;
                            }

                            return $domain->grants[$year]->toInteger();
                        })->toArray(),
                    ];
                })
                ->filter(fn ($dataset) => collect($dataset['data'])->contains(fn ($value) => $value > 0))
                ->values()
            // ->dd(),
                ->toArray(),
        ];
    }
}
