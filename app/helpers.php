<?php

declare(strict_types=1);

if (! function_exists('localizedRoute')) {
    function localizedRoute(string $route, ?string $slug = null)
    {
        return toLocaleRoute(app()->getLocale(), $route, $slug);
    }
}

if (! function_exists('toLocaleRoute')) {
    function toLocaleRoute(string $locale, string $route, ?string $slug = null)
    {
        return route($route, [
            'locale' => $locale,
            'slug'   => $slug,
        ]);
    }
}
