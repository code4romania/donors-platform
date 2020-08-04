<?php

declare(strict_types=1);

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class FocusArea extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'translation',
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
     * @var array
     */
    public $translatedAttributes = [
        'name',
    ];

    public function donors()
    {
        return $this->belongsToMany(Donor::class);
    }
}
