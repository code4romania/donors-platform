<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

trait Sortable
{
    /**
     * Columns that should always be sortable, regardless of configuration.
     *
     * @var array
     */
    private array $defaultColumns = [
        'id', 'created_at', 'updated_at',
    ];

    /**
     * Sort by request params.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeSort(Builder $query): Builder
    {
        $column = Request::input('order', null);
        $direction = Request::input('direction', 'asc');

        if (in_array($column, $this->sortable_columns)) {
            return $query->orderBy($column, $direction);
        }

        // Column not sortable
        return $query;
    }

    public function getSortableColumnsAttribute(): array
    {
        // Not set up properly
        if (! property_exists($this, 'sortable') || ! is_array($this->sortable)) {
            return [];
        }

        return array_merge($this->sortable, $this->defaultColumns);
    }
}
