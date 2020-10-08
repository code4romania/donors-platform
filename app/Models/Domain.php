<?php

declare(strict_types=1);

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Domain extends Model implements TranslatableContract
{
    use HasRecursiveRelationships,
        LogsActivity,
        Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'parent_id',
    ];

    /**
     * @var string[]
     */
    public $translatedAttributes = [
        'name',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        'translations',
    ];

    /**
     * morphedByMany template.
     *
     * @param  string      $related
     * @return MorphToMany
     */
    private function relatedTo(string $related): MorphToMany
    {
        return $this->morphedByMany(
            $related,
            'model',
            'model_has_domains',
            'domain_id',
            'model_id'
        );
    }

    public function donors(): MorphToMany
    {
        return $this->relatedTo(Donor::class);
    }

    public function managers(): MorphToMany
    {
        return $this->relatedTo(GrantManager::class);
    }

    public function grants(): MorphToMany
    {
        return $this->relatedTo(Grant::class);
    }

    public function getGrantStatsAttribute()
    {
        return $this->grants()->aggregateByMonth()->get();
    }

    public static function walkTree(?Collection $domains = null, ?int $parent = null): Collection
    {
        $domains ??= self::tree()->get();

        return $domains
            ->reject(fn ($domain) => $domain->parent_id !== $parent)
            ->map(function ($domain) use ($domains) {
                $item = [
                    'id'    => $domain->id,
                    'name'  => $domain->name,
                    'depth' => $domain->depth,
                ];

                $children = self::walkTree($domains, $domain->id);

                if ($children) {
                    $item['children'] = $children;
                }

                return (object) $item;
            })
            ->sortBy('name')
            ->values();
    }

    public static function flatTree(?Collection $domains = null)
    {
        $domains ??= self::walkTree();
        $flattened = collect();

        $domains->each(function ($domain) use ($flattened) {
            if ($domain->children) {
                $children = $domain->children;
                unset($domain->children);
            }

            $flattened->push($domain);

            if ($children) {
                $flattened->push(self::flatTree($children));
            }
        });

        return $flattened->flatten();
    }

    public static function cachedWalkTree(?Collection $domains = null)
    {
        return Cache::tags(['domains'])->rememberForever(
            'domain_tree_' . App::getLocale(),
            fn () => self::walkTree()
        );
    }

    public static function cachedFlatTree(?Collection $domains = null)
    {
        return Cache::tags(['domains'])->rememberForever(
            'domain_tree_flat_' . App::getLocale(),
            fn () => self::flatTree()
        );
    }
}
