<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\FocusAreaTranslation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class FocusArea extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name'];

    public $translationModel = FocusAreaTranslation::class;
}
