<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use App\Models\Project;
use App\Services\Exchange;
use App\Traits\HandlesSEO;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class PageController extends Controller
{
    use HandlesSEO;

    public function index(string $locale)
    {
        $this->setSeo([
            'title'       => __('public.title'),
            'description' => __('public.description.0'),
            'routeName'   => 'front.index',
        ]);

        $grants = Grant::query()
            ->with('primaryDomain', 'domains')
            ->published()
            ->get();

        return view('front.pages.index', [
            'donors_count'      => 15, //Donor::published()->count(),
            'foundations_count' => 19,
            'projects_count'    => Project::count(),
            'grantees_count'    => Grantee::count(),
            'domains_count'     => $grants->pluck('domains')
                ->flatten()
                ->unique('id')
                ->count(),
            'grants_total'      => Exchange::sumForCurrency($grants)
                ->formatWithoutDecimals(),

            'years'   => $this->getSortedYears(),
            'domains' => Domain::walkTree(null, null, ['disabled']),
        ]);
    }

    public function show(string $locale, ?string $slug)
    {
        // Check for dedicated views
        $views = [
            "front.pages.$locale.$slug",
            "front.pages.$slug",
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                $this->setSeo([
                    'title'       => __("public.pages.{$slug}.title"),
                    'description' => __("public.pages.{$slug}.description"),
                    'routeName'   => 'front.page',
                    'routeArg'    => $slug,
                ]);

                return view($view);
            }
        }

        // Check for markdown
        $path = "pages/{$slug}-{$locale}.md";

        if (! Storage::disk('content')->exists($path)) {
            abort(404);
        }

        $content = YamlFrontMatter::parse(
            Storage::disk('content')->get($path)
        );

        $this->setSeo([
            'title'       => $content->matter('title'),
            'description' => $content->matter('summary'),
            'routeName'   => 'front.page',
            'routeArg'    => $slug,
        ]);

        return view('front.pages.show', [
            'meta'    => $content->matter(),
            'content' => Str::markdown($content->body()),
        ]);
    }
}
