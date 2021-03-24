<?php

declare(strict_types=1);

namespace App\Traits;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Str;

trait HandlesSEO
{
    public function setSeo(array $params = []): void
    {
        $params = array_merge([
            'title'       => '',
            'description' => '',
            'routeName'   => '',
            'routeArg'    => '',
        ], $params);

        $title = trim($params['title']);
        if (! empty($title)) {
            SEOTools::setTitle($title);
        }

        $description = Str::limit(strip_tags($params['description'] ?? ''), 170);
        if (! empty($description)) {
            SEOTools::setDescription($description);
        }

        if (! empty($routeName) && ! empty($routeArg) && isset($$routeArg)) {
            $routeArg = ($routeArg !== 'page' || $page > 1) ? compact($routeArg) : [];

            SEOTools::setCanonical(route($routeName, $routeArg));
        }
    }
}
