<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

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
                    'name'         => $column,
                    'sortable'     => in_array($column, $sortable),
                    'translatable' => in_array($column, $translatable),
                ];
            });
    }
}
