<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDomains;
use App\Traits\HasGrants;
use App\Traits\HasLogo;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;

class GrantManager extends Model
{
    use Draftable,
        Filterable,
        HasGrants,
        HasDomains,
        HasLogo,
        LogsActivity,
        Searchable,
        Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'hq', 'contact', 'email', 'phone', 'logo',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * The attributes that are filterable.
     *
     * @var string[]
     */
    protected $filterable = [
        'domains', //'donors',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var string[]
     */
    protected $sortable = [
        'name', 'grants_count', 'grantees_count',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        // 'domains', 'grants', 'media',
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

    public function users()
    {
        return $this->morphMany(User::class, 'organization');
    }

    public function grants()
    {
        return $this->hasMany(Grant::class);
    }
}
