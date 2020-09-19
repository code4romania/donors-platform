<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function grouped(): array
    {
        return (new static)::pluck('name')
            ->groupBy(fn ($permission) => Str::singular(explode('.', $permission)[0]))
            ->map
            ->map(fn ($permission) => explode('.', $permission)[1])
            ->toArray();
    }
}
