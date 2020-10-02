<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\Enum\Laravel\Enum as BaseEnum;

class Enum extends BaseEnum
{
    public static function asOptions(): array
    {
        return collect(self::toArray())
            ->map(fn ($label, $value) => [
                'value' => $value,
                'label' => $label,
            ])
            ->values()
            ->toArray();
    }
}
