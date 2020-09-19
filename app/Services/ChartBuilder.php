<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class ChartBuilder
{
    public static function data(Collection $collection): array
    {
        $collection = $collection->map(function ($item) {
            $item->stats = $item->grant_stats
                ->groupBy('year')
                ->sortKeys()
                ->map(fn ($grants) => $item->sumForCurrency($grants));

            return $item;
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
                ->map(function ($item) use ($years) {
                    $stats = $item->stats;

                    return [
                        'label' => $item->name,
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
