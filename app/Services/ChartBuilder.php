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
            $domain->stats = $domain->grant_stats
                ->groupBy('year')
                ->sortKeys()
                ->map(fn ($grants) => $domain->sumForCurrency($grants));

            return $domain;
        });

        $years = $collection
            ->pluck('stats')
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
                    $stats = $domain->stats;

                    return [
                        'label' => $domain->name,
                        'data'  => $years->map(function ($year) use ($stats) {
                            if (! $stats->has($year)) {
                                return 0;
                            }

                            return $stats[$year]->toInteger();
                        })->toArray(),
                    ];
                })
                ->filter(fn ($dataset) => collect($dataset['data'])->contains(fn ($value) => $value > 0))
                ->values()
                ->toArray(),
        ];
    }
}
