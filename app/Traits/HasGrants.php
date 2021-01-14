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

    abstract public function grants();

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
