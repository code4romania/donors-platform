<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Grant;

trait HasGrants
{
    use HasExchangeRates;

    public function grants()
    {
        return $this->morphToMany(
            Grant::class,
            'model',
            'model_has_grants',
            'model_id',
            'grant_id',
        );
    }

    public function getGrantCountAttribute()
    {
        return $this->grants()->count();
    }

    public function getGranteeCountAttribute()
    {
        return $this->grants->map->grantees->flatten()->count();
    }

    public function getGrantDomainsAttribute()
    {
        return $this->grants()
            ->with('domains')
            ->get()
            ->pluck('domains')
            ->flatten()
            ->unique('id');
    }

    public function getTotalFundingAttribute()
    {
        return $this->sumForCurrency(
            $this->grants()
                ->aggregateByMonth()
                ->get('amount', 'date', 'currency', 'rate_*')
        );
    }
}
