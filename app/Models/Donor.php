<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrganizationType;
use App\Services\Exchange;
use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDomains;
use App\Traits\HasGrants;
use App\Traits\HasLogo;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Donor extends Model
{
    use Draftable,
        Filterable,
        HasDomains,
        HasGrants,
        HasLogo,
        HasRelationships,
        LogsActivity,
        Searchable,
        Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'type', 'hq', 'contact', 'email', 'phone', 'logo',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'published_at' => 'datetime',
        'type'         => OrganizationType::class,
    ];

    /**
     * The attributes that are filterable.
     *
     * @var string[]
     */
    protected $filterable = [
        'domains', 'managers', 'orgtype',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var string[]
     */
    protected $sortable = [
        'name', 'type', 'grants_count', 'grantees_count',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        // 'media',
    ];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    protected $withCount = [
        //
    ];

    public function getSearchableTitleColumns(): array
    {
        return [
            'name',
        ];
    }

    public function getSearchableContentColumns(): array
    {
        return [
            'hq', 'contact', 'email',
        ];
    }

    public function grants()
    {
        return $this->belongsToMany(Grant::class)
            ->using(Contribution::class)
            ->as('contribution')
            ->with('domains')
            ->withPivot('amount', 'grant_currency');
    }

    public function managers()
    {
        return $this->hasManyDeepFromRelations(
            $this->grants(),
            (new Grant)->manager()
        );
    }

    public function users()
    {
        return $this->morphMany(User::class, 'organization');
    }

    public function getTotalFundingAttribute()
    {
        return Exchange::sumForCurrency($this->grants, null, 'contribution.amount');
    }
}
