<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDomains;
use App\Traits\Sortable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        // 'media',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo') ?: null;
    }

    public function getTotalFundingAttribute(): Collection
    {
        return DB::table('grants')
            ->join('donor_grant', 'grants.id', '=', 'donor_grant.grant_id')
            ->where('donor_grant.donor_id', '=', $this->id)
            ->select(
                DB::raw('SUM(amount) as amount'),
                DB::raw('DATE_FORMAT(start_date, "%Y-%m") as date'),
                'currency'
            )
            ->groupBy('date', 'currency')
            ->get('amount', 'date', 'currency');
    }

    public function getGrantCountAttribute()
    {
        return $this->grants()->count();
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
