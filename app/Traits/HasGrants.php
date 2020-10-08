<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Grant;
use App\Models\Project;
use App\Services\Exchange;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

trait HasGrants
{
    use HasRelationships;

    public function grants()
    {
        return $this->morphToMany(
            Grant::class,
            'model',
            'model_has_grants',
            'model_id',
            'grant_id',
        )->with('domains');
    }

    public function grantees()
    {
        return $this->hasManyDeepFromRelations(
            $this->grants(),
            (new Grant)->projects(),
            (new Project)->grantees(),
        )->distinct();
    }

    public function getGrantDomainsAttribute()
    {
        return $this->grants
            ->pluck('domains')
            ->flatten()
            ->unique('id');
    }

    public function getTotalFundingAttribute()
    {
        return Exchange::sumForCurrency($this->grants);
    }

    public function getTotalRegrantingAttribute()
    {
        return Exchange::sumForCurrency($this->grants, null, 'regranting_amount');
    }
}
