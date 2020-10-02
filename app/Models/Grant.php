<?php

declare(strict_types=1);

namespace App\Models;

use App\Scopes\WithExchangeRatesScope;
use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDates;
use App\Traits\HasDomains;
use App\Traits\HasExchangeRates;
use App\Traits\Sortable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cknow\Money\Money;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Grant extends Model implements TranslatableContract
{
    use Draftable,
        Filterable,
        HasDates,
        HasDomains,
        HasExchangeRates,
        HasRelationships,
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
     * The attributes that are filterable.
     *
     * @var string[]
     */
    protected $filterable = [
        'donors', 'domains', 'managers',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var string[]
     */
    protected $sortable = [
        'name', 'amount', 'regranting_amount', 'start_date', 'end_date',
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
        // 'donors', 'domains.translation', 'projects', 'translations',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new WithExchangeRatesScope);
    }

    /**
     * morphedByMany template.
     *
     * @param  string      $related
     * @return MorphToMany
     */
    private function relatedTo(string $related): MorphToMany
    {
        return $this->morphedByMany(
            $related,
            'model',
            'model_has_grants',
            'grant_id',
            'model_id'
        );
    }

    public function donors(): MorphToMany
    {
        return $this->relatedTo(Donor::class);
    }

    public function managers(): MorphToMany
    {
        return $this->relatedTo(GrantManager::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function grantees(): HasManyDeep
    {
        return $this->hasManyDeep(
            Grantee::class,
            [Project::class, 'grantee_project'],
            [null, 'project_id', 'id'],
            [null, 'id', 'grantee_id']
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

    public function scopeAggregateByMonth(Builder $query, string $column = 'amount')
    {
        if (! in_array($column, ['amount', 'regranting_amount'])) {
            return $query;
        }

        return $query
            ->addSelect('currency')
            ->selectRaw('SUM(' . $column . ') as amount')
            ->selectRaw('LAST_DAY(start_date) as date')
            ->selectRaw('YEAR(start_date) as year')
            ->groupBy('date', 'currency');
    }
}
