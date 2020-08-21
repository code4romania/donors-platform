<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Sortable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

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

    public function donors()
    {
        return $this->morphedByMany(Donor::class, 'domainable');
    }
}
