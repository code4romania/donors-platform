<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Domain;
use App\Services\Normalize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait Filterable
{
    public function scopeFilter(Builder $query): Builder
    {
        $filters = Request::input('filters', '');

        return $query->when($filters, function (Builder $query, $filters) {
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
                        $query->filterByDomains(Domain::find($value)->descendantsAndSelf->pluck('id'));
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
        });
    }

    public function scopeFilterByDomains(Builder $query, iterable $domains): Builder
    {
        return $query->whereHas('domains', fn ($query) => $query->whereIn('domains.id', $domains));
    }

    public function scopeFilterByPrimaryDomains(Builder $query, iterable $domains): Builder
    {
        return $query->whereHas('primaryDomain', fn ($query) => $query->whereIn('domains.id', $domains));
    }

    public function scopeFilterByRelationshipId(Builder $query, string $relationship, int $id, ?string $tableName = null): Builder
    {
        $tableName ??= $relationship;

        return $query->whereHas($relationship, fn ($query) => $query->where("{$tableName}.id", $id));
    }

    public function scopeGetColumn(Builder $query, string $column): Collection
    {
        return $query->select($this->getTable() . '.id', $column)->get();
    }
}
