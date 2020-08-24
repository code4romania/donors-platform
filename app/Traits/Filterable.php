<?php

declare(strict_types=1);

namespace App\Traits;

use App\Services\Normalize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

trait Filterable
{
    use Searchable;

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        $filters = $this->sanitizeFilters($filters);

        return $query->when($filters['search'], function ($q, $search) {
            return $q->whereIn('id', $this->search($search)->keys());
        });
    }

    protected function sanitizeFilters(array $filters): Collection
    {
        $defaults = collect([
            'search' => Request::input('search'),
        ]);

        return $defaults
            ->merge($filters)
            ->map(fn ($filter) => Normalize::string($filter));
    }

    public function toSearchableArray(): array
    {
        if (! isset($this->searchable)) {
            return [];
        }

        [$relationshipAttributes, $modelAttributes] = collect($this->searchable)
            ->partition(fn ($attr) => Str::contains($attr, '.'));

        return collect($this->only($modelAttributes->toArray()))
            ->merge(
                $relationshipAttributes->map(function ($item) {
                    [$relationship, $attribute] = explode('.', $item);

                    if (! method_exists($this, $relationship)) {
                        return null;
                    }

                    return $this->$relationship->pluck($attribute);
                })
            )
            ->filter()
            ->map(fn ($item): string => Normalize::string($item))
            ->toArray();
    }
}
