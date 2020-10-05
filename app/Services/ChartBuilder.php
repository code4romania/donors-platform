<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Carbon;
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
            ->map(fn ($grant) => $grant->keys())
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return [
            'currency' => self::getActiveCurrency(),
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

    public static function dashboard(Collection $domains): array
    {
        $stats = $domains
            ->when(self::getActiveDomains(), function ($domains) {
                return $domains->filter(
                    fn ($domain) => in_array($domain->id, self::getActiveDomains())
                );
            })
            ->map(fn ($item) => [
                'name'  => $item->name,
                'years' => $item->grants
                    ->groupBy('year')
                    ->sortKeys()
                    ->filter(fn ($_, $year) => in_array($year, self::getActiveYears()))
                    ->map(fn ($grants) => $item->sumForCurrency($grants)),
            ]);

        $years = $stats
            ->pluck('years')
            ->reject(fn ($grant) => $grant->isEmpty())
            ->map(fn ($grant) => $grant->keys())
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return [
            'options' => [
                'currency'   => self::getActiveCurrency(),
                'xaxis' => [
                    'categories' => $years->toArray(),
                ],
            ],
            'series'     => $stats
                ->map(fn ($item) => [
                    'name' => $item['name'],
                    'data' => $years
                        ->map(fn ($year) => $item['years']->has($year) ? $item['years'][$year]->toInteger() : 0)
                        ->toArray(),
                ])
                ->filter(fn ($item) => collect($item['data'])->contains(fn ($value) => $value > 0))
                ->values()
                ->toArray(),
        ];
    }

    private static function getActiveCurrency(): string
    {
        return Request::input('currency', config('money.defaultCurrency'));
    }

    private static function getActiveYears(): array
    {
        return Request::input('filters.years', [
            Carbon::now()->year,
            Carbon::now()->subYear()->year,
        ]);
    }

    private static function getActiveDomains(): array
    {
        return Request::input('filters.domains', []);
    }

    private static function getActiveDonors(): array
    {
        return Request::input('filters.donors', []);
    }
}
