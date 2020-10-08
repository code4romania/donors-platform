<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;

class ChartBuilder
{
    public static function dashboard(): array
    {
        $domains = Domain::tree()
            ->with('descendantsAndSelf.grants')
            ->withTranslation()
            ->when(
                self::getActiveDomains(),
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
                ->filter(fn ($_, $year) => in_array($year, self::getActiveYears()))
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
