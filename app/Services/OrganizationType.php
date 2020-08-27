<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

class OrganizationType
{
    /** @var string[] */
    private static $types = [
        'foundation',
        'federation',
        'company',
    ];

    private static function translate(string $key): ?string
    {
        return Lang::has("dashboard.org_types.{$key}")
            ? __("dashboard.org_types.{$key}")
            : null;
    }

    public static function types(): Collection
    {
        return collect(self::$types);
    }

    public static function all(): Collection
    {
        return self::types()
            ->map(function ($key) {
                return [
                    'value' => $key,
                    'label' => self::translate($key),
                ];
            })
            ->filter(fn ($key) => $key['label'] !== null);
    }

    public static function get(string $key): ?array
    {
        return self::all()->firstWhere('value', $key);
    }
}
