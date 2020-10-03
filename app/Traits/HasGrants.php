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

    public function getGranteeCountAttribute()
    {
        return $this->grants->load('grantees')->map->grantees->flatten()->count();
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
                ->aggregateByMonth('amount')
                ->get('amount', 'date', 'currency', 'rate_*')
        );
    }

    public function getTotalRegrantingAttribute()
    {
        return $this->sumForCurrency(
            $this->grants()
                ->aggregateByMonth('regranting_amount')
                ->get('amount', 'date', 'currency', 'rate_*')
        );
    }
}
