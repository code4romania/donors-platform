<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDomains;
use App\Traits\Sortable;
use Cknow\Money\Money;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Donor extends Model implements HasMedia
{
    use Draftable,
        Filterable,
        HasDomains,
        InteractsWithMedia,
        Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'type', 'hq', 'contact', 'email', 'phone',
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
     * @var string[]
     */
    public $searchable = [
        'id', 'name', 'hq', 'contact', 'email',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var string[]
     */
    protected $sortable = [
        'name', 'type',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        'media',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var string[]
     */
    protected $appends = [
        'logo_url', 'total_funding',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo') ?: null;
    }

    public function getTotalFundingAttribute()
    {
        return $this->grants
            ->pluck('amount')
            ->filter()
            ->unlessEmpty(
                fn ($amounts) => Money::sum(...$amounts),
                fn () => money(0),
            );
    }

    public function getGrantCountAttribute()
    {
        return $this->grants->count();
    }

    public function getGranteeCountAttribute()
    {
        return Grantee::query()->count();
    }

    public function grants()
    {
        return $this->belongsToMany(Grant::class);
    }
}
