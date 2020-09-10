<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDates;
use App\Traits\HasDomains;
use App\Traits\Sortable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cknow\Money\Money;
use Cknow\Money\MoneyCast;

class Grant extends Model implements TranslatableContract
{
    use Draftable,
        Filterable,
        HasDates,
        HasDomains,
        Sortable,
        Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'description', 'amount', 'currency', 'start_date', 'end_date', 'project_count', 'regranting_amount', 'matching',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'start_date'        => 'date',
        'end_date'          => 'date',
        'published_at'      => 'datetime',
        'matching'          => 'boolean',
        'amount'            => MoneyCast::class . ':currency',
        'regranting_amount' => MoneyCast::class . ':currency',
    ];

    /**
     * @var string[]
     */
    public $searchable = [
        'id', 'name', 'donors.name',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var string[]
     */
    protected $sortable = [
        'name', 'amount',
    ];

    /**
     * @var string[]
     */
    public $translatedAttributes = [
        'name', 'description',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        'domains', 'projects', 'translations',
    ];

    public function donors()
    {
        return $this->belongsToMany(Donor::class);
    }

    public function manager()
    {
        return $this->belongsTo(GrantManager::class, 'grant_manager_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function grantees()
    {
        return $this->hasManyThrough(
            Grantee::class,
            Project::class,
            'grant_id',  // Foreign key on projects table
            'id',        // Foreign key on grantees table
            'id',        // Local key on grants table
            'grantee_id' // Local key on projects table
        )->groupBy('id');
    }

    public function getGrantableAmountAttribute(): Money
    {
        return $this->regranting_amount ?? $this->amount;
    }

    public function getGrantedAmountAttribute(): Money
    {
        return Money::parseByDecimal(
            $this->projects()->sum('amount'),
            $this->currency
        );
    }

    public function getRemainingAmountAttribute(): Money
    {
        return $this->grantable_amount->subtract($this->granted_amount);
    }
}
