<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Sortable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Domain extends Model implements TranslatableContract
{
    use Sortable, Translatable;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'translations',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var array
     */
    protected $sortable = [
        'name',
    ];

    /**
     * @var array
     */
    public $translatedAttributes = [
        'name',
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
}
