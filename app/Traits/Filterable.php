<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Domain;
use App\Services\Normalize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

trait Filterable
{
    use Searchable;

    public function scopeFilter(Builder $query): Builder
    {
        return $query
            ->when(Request::input('search'), function (Builder $query, string $term) {
                $query->whereIn('id', $this->search(Normalize::string($term))->keys());
            })
            ->when(Request::input('filters'), function (Builder $query, $filters) {
                $this->filter($query, $filters);
            });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed                                 $filters
     * @return void
     */
    private function filter(Builder $query, $filters): void
    {
        if (! isset($this->filterable)) {
            return;
        }

        if (is_string($filters)) {
            $filters = json_decode($filters, true);
        }

        collect($filters)->each(function ($value, $key) use ($query) {
            $relationship = Str::plural($key);

            if (
                ! in_array($key, $this->filterable) &&
                ! in_array($relationship, $this->filterable)
            ) {
                return;
            }

            switch ($key) {
                case 'domain':
                    $query->filterByDomains(
                        Domain::find($value)->descendantsAndSelf->pluck('id')
                    );
                    break;

                case 'donor':
                case 'grantee':
                    $query->filterByRelationshipId($relationship, (int) $value);
                    break;

                case 'manager':
                    $query->filterByRelationshipId($relationship, (int) $value, 'grant_managers');
                    break;

                case 'orgtype':
                    $query->where('type', Normalize::string($value));
                    break;
            }
        });
    }

    public function scopeFilterByDomains(Builder $query, iterable $domains): Builder
    {
        return $query->whereHas(
            'domains',
            fn ($query) => $query->whereIn('domains.id', $domains)
        );
    }

    public function scopeFilterByPrimaryDomains(Builder $query, iterable $domains): Builder
    {
        return $query->whereHas(
            'primaryDomain',
            fn ($query) => $query->whereIn('domains.id', $domains)
        );
    }

    public function scopeFilterByRelationshipId(Builder $query, string $relationship, int $id, ?string $tableName = null): Builder
    {
        $tableName ??= $relationship;

        return $query->whereHas(
            $relationship,
            fn ($query) => $query->where("{$tableName}.id", $id)
        );
    }

    public function scopeGetColumn(Builder $query, string $column): Collection
    {
        return $query->select($this->getTable() . '.id', $column)->get();
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
