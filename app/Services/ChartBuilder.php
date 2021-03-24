<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Builder;

class ChartBuilder
{
    public static function data(array $activeYears, ?array $activeDomains = null): array
    {
        $domains = Domain::tree()
            ->with('descendantsAndSelf.grants')
            ->withTranslation()
            ->when(
                $activeDomains,
                fn (Builder $query, array $domains) => $query->whereIn('id', $domains),
                fn (Builder $query) => $query->whereNull('parent_id')
            )
            ->get();

        $stats = $domains->map(fn ($domain) => [
            'name'  => $domain->name,
            'years' => $domain->descendantsAndSelf
                ->pluck('grants')
                ->flatten()
                ->groupBy('year')
                ->sortKeys()
                ->filter(fn ($_, $year) => in_array($year, $activeYears))
                ->map(fn ($grants) => Exchange::sumForCurrency($grants)),
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
                'currency' => Exchange::currency(),
                'xaxis' => [
                    'categories' => $years->toArray(),
                ],
            ],
            'series' => $stats
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
}
