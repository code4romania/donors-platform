<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    public function getTranslatableAttribute()
    {
        return $this->translatedAttributes ?? [];
    }
}
