<?php

declare(strict_types=1);

namespace App\Traits;

use App\Services\Normalize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

trait Filterable
{
    use Searchable;

    public function scopeFilter(Builder $query): Builder
    {
        $filters = collect(Request::all('search', 'domain', 'donor', 'manager', 'orgtype'))
            ->map(fn ($filter) => Normalize::string($filter));

        return $query
            ->when($filters['search'], fn ($q, string $search) => $q->whereIn($this->getTable() . '.id', $this->search($search)->keys()))
            ->when($filters['domain'], fn ($q, int $domain) => $this->whereHas($q, $domain, 'domains'))
            ->when($filters['donor'], fn ($q, int $donor) => $this->whereHas($q, $donor, 'donors'))
            ->when($filters['manager'], fn ($q, int $manager) => $this->whereHas($q, $manager, 'managers'))
            ->when($filters['orgtype'], fn ($q, string $type) => $q->where('type', $type));
    }

    public function scopeGetColumn(Builder $query, string $column): Collection
    {
        return $query->select($this->getTable() . '.id', $column)->get();
    }

    protected function whereHas(Builder $query, int $id, string $relationship): Builder
    {
        return $query->whereHas($relationship, fn ($q) => $q->where('id', $id));
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
