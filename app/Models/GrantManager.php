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

class GrantManager extends Model implements HasMedia
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
        'name',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        // 'domains', 'grants', 'media',
    ];

    public function grants()
    {
        return $this->hasMany(Grant::class);
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
