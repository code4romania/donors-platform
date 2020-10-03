<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrganizationType;
use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDomains;
use App\Traits\HasGrants;
use App\Traits\HasLogo;
use App\Traits\Sortable;
use Spatie\MediaLibrary\HasMedia;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Donor extends Model implements HasMedia
{
    use Draftable,
        Filterable,
        HasDomains,
        HasGrants,
        HasLogo,
        HasRelationships,
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
     * @var string[]
     */
    public $searchable = [
        'id', 'name', 'hq', 'contact', 'email',
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
        'name', 'type', 'grants_count',
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
        'grants',
    ];

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
}
