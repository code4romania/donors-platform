<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public string $title;

    public Carbon $date;

    public string $slug;

    public ?string $author;

    public ?string $summary;

    public ?string $content;

    public function __construct(array $attributes = [])
    {
        $this->title = $attributes['title'];
        $this->slug = $attributes['slug'];
        $this->date = Carbon::createFromFormat('Y-m-d', $attributes['date']);

        $this->author = $attributes['author'] ?? null;
        $this->content = $attributes['content'] ?? null;
        $this->summary = $attributes['summary'] ?? null;
    }

    public static function all(): Collection
    {
        return Cache::remember('posts-' . app()->getLocale(), 5, function () {
            return collect(Storage::disk('content')->allFiles('posts'))
                ->filter(fn ($path) => Str::endsWith($path, app()->getLocale() . '.md'))
                ->map(function ($path) {
                    $content = YamlFrontMatter::parse(
                        Storage::disk('content')->get($path)
                    );

                    [$date, $slug] = explode('_', basename($path));

                    return new self([
                        'title'   => $content->matter('title'),
                        'author'  => $content->matter('author'),
                        'date'    => $date,
                        'slug'    => $slug,
                        'summary' => $content->matter('summary'),
                        'content' => Str::markdown($content->body()),
                    ]);
                })
                ->sortByDesc('date');
        });
    }

    public static function findBy(string $property, $value): ?self
    {
        return self::all()
            ->filter(fn (self $post) => property_exists($post, $property) && $post->$property === $value)
            ->first();
    }

    protected static function compile($content, array $args = [])
    {
        $content = Blade::compileString($content);
    }
}
