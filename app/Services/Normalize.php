<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class Normalize
{
    /**
     * Strip tags and normalize the string to lowercase ascii.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function string($value): string
    {
        return (string) Str::of(self::cleanup($value))
            ->lower()
            ->ascii();
    }

    public static function cleanup($value): string
    {
        return html_entity_decode(
            strip_tags(
                (string) $value
            )
        );
    }
}
