<?php

declare(strict_types=1);

namespace App\Models;

use App\Scopes\WithExchangeRatesScope;
use App\Traits\Filterable;
use App\Traits\HasDates;
use App\Traits\HasDomains;
use App\Traits\Sortable;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    use Filterable,
        HasDates,
        HasDomains,
        Sortable;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('withGrantCurrency', function (Builder $query) {
            return $query->addSelect([
                'currency' => Grant::query()
                    ->withoutGlobalScope(WithExchangeRatesScope::class)
                    ->select('currency')
                    ->whereColumn('grant_id', 'grants.id')
                    ->latest()
                    ->take(1),
            ]);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title', 'amount', 'start_date', 'end_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'amount'     => MoneyCast::class . ':currency',
        'currency'   => 'string',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * @var string[]
     */
    public $searchable = [
        'id', 'title', 'grantees.name',
    ];

    /**
     * @var string[]
     */
    public $sortable = [
        'title', 'amount', 'start_date', 'end_date',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        'grantees',
    ];

    public function donors()
    {
        return $this->belongsTo(Donor::class);
    }

    public function grant()
    {
        return $this->belongsTo(Grant::class);
    }

    public function grantees()
    {
        return $this->belongsToMany(Grantee::class);
    }
}
