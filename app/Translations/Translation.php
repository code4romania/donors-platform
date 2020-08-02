<?php

declare(strict_types=1);

namespace App\Translations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Translation extends Model
{
    public function getFillable()
    {
        // If the fillable attribute is filled, just use it
        $fillable = $this->fillable;

        // If fillable is empty
        // and it's a translation model
        // and the baseModel was defined
        // Use the list of translatable attributes on our base model
        if (
            blank($fillable) &&
            Str::contains($class = get_class($this), '\Translations') &&
            property_exists($class, 'baseModel')
        ) {
            $fillable = (new $this->baseModel)->translatedAttributes;

            if (! collect($fillable)->contains('locale')) {
                $fillable[] = 'locale';
            }
        }

        return $fillable;
    }
}
