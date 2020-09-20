<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;

trait HasUsers
{
    public function users()
    {
        return $this->morphToMany(
            User::class,
            'model',
            'user_manages_model',
            'model_id',
            'user_id',
        );
    }
}
