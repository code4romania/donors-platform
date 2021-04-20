<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use ProVision\Searchable\SearchableModes;
use ProVision\Searchable\Traits\SearchableTrait;

trait Searchable
{
    use SearchableTrait {
        scopeSearch as scopeSearchIndex;
    }

    public function scopeSearch(Builder $query): Builder
    {
        $terms = collect(explode(' ', (string) Request::input('search')))
            ->reject(fn (string $term) => Str::length($term) < 3)
            ->map(fn (string $term) => "+{$term}*")
            ->join(' ');

        return $query->when($terms, function (Builder $query, $terms) {
            $query->searchIndex($terms, SearchableModes::Boolean);
        });
    }
}
