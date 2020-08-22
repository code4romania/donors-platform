<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Domain;

trait HasDomains
{
    public function domains()
    {
        return $this->morphToMany(
            Domain::class,
            'model',
            'model_has_domains',
            'model_id',
            'domain_id',
        );
    }
}
