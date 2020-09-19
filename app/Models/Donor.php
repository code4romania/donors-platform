<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDomains;
use App\Traits\HasExchangeRates;
use App\Traits\HasLogo;
use App\Traits\Sortable;
use Spatie\MediaLibrary\HasMedia;

class Donor extends Model implements HasMedia
{
    use Draftable,
        Filterable,
        HasDomains,
        HasExchangeRates,
        HasLogo,
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
        // 'media',
    ];

    public function grants()
    {
        return $this->belongsToMany(Grant::class);
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
