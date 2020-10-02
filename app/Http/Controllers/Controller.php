<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getIndexColumns(string $model, array $columns): Collection
    {
        $sortable = app($model)->sortable_columns ?? [];
        $translatable = app($model)->translatable ?? [];

        return collect($columns)
            ->map(function (string $column) use ($sortable, $translatable) {
                return [
                    'field'        => str_replace('.', '___', $column),
                    'label'        => __("field.{$column}"),
                    'sortable'     => in_array($column, $sortable),
                    'translatable' => in_array($column, $translatable),
                ];
            });
    }

    public function getSortedDonors(array $columns = ['id', 'name']): Collection
    {
        return DB::table('donors')
            ->orderBy('name', 'asc')
            ->get($columns);
    }

    public function getSortedManagers(array $columns = ['id', 'name']): Collection
    {
        return DB::table('grant_managers')
            ->orderBy('name', 'asc')
            ->get($columns);
    }

    public function getSortedDomains(array $columns = ['id', 'name']): Collection
    {
        return Domain::orderByTranslation('name', 'asc')
            ->get($columns)
            ->map->only(...$columns);
    }
}
