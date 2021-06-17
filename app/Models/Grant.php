<?php

declare(strict_types=1);

namespace App\Models;

use App\Scopes\WithExchangeRatesScope;
use App\Services\Exchange;
use App\Traits\Draftable;
use App\Traits\Filterable;
use App\Traits\HasDates;
use App\Traits\HasDomains;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cknow\Money\Money;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Grant extends Model implements TranslatableContract
{
    use Draftable,
        Filterable,
        HasDates,
        HasDomains,
        HasRelationships,
        LogsActivity,
        Searchable,
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
     * The attributes that are filterable.
     *
     * @var string[]
     */
    protected $filterable = [
        'donors', 'domains', 'managers', 'grantees',
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
        // 'primaryDomain', 'secondaryDomains',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new WithExchangeRatesScope);

        static::addGlobalScope('withYear', function ($query) {
            return $query->withYear();
        });
    }

    public function getSearchableTitleColumns(): array
    {
        return [
            'name',
        ];
    }

    public function getSearchableContentColumns(): array
    {
        return [
            'donors.name',
        ];
    }

    public function users()
    {
        return $this->morphMany(User::class, 'owner');
    }

    public function donors()
    {
        return $this->belongsToMany(Donor::class)
            ->using(Contribution::class)
            ->as('contribution')
            ->withPivot('amount', 'grant_currency');
    }

    /**
     * Alias needed for filtering.
     */
    public function managers()
    {
        return $this->manager();
    }

    public function manager()
    {
        return $this->belongsTo(GrantManager::class, 'grant_manager_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function grantees(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->projects(),
            (new Project)->grantees(),
        )
            ->distinct();
    }

    public function primaryDomain()
    {
        return $this->domains()->wherePivot('primary', true);
    }

    public function secondaryDomains()
    {
        return $this->domains()->wherePivot('primary', false);
    }

    /**
     * @param  string|int $primary   Primary domain id
     * @param  null|array $secondary Array of secondary domain ids
     * @return array
     */
    public function syncDomains($primary, ?array $secondary = []): array
    {
        $domains = [];
        $secondary ??= [];

        foreach ($secondary as $domain) {
            $domains[$domain] = ['primary' => false];
        }

        $domains[$primary] = ['primary' => true];

        return $this->domains()->sync($domains);
    }

    public function syncDonors(array $donors, string $currency): void
    {
        $this->donors()->sync(
            collect($donors)
                ->mapWithKeys(fn ($donor) => [
                    $donor['id'] => [
                        'amount'         => (float) $donor['amount'],
                        'grant_currency' => $currency,
                    ],
                ])
                ->all()
        );
    }

    public function getRegrantingAmountAttribute(): ?Money
    {
        if (! $this->grant_manager_id) {
            return null;
        }

        return Money::parseByDecimal($this->attributes['regranting_amount'], $this->currency);
    }

    public function getOperationalCostsAttribute(): ?Money
    {
        if (! $this->grant_manager_id) {
            return null;
        }

        if (! $this->regranting_amount) {
            return Money::parse(0, $this->currency);
        }

        return $this->amount->subtract(
            $this->regranting_amount
        );
    }

    public function getConvertedAmountAttribute(): Money
    {
        return Exchange::convert($this->amount, Exchange::currency(), $this->rate);
    }

    public function getGrantableAmountAttribute(): Money
    {
        return $this->grant_manager_id ? $this->regranting_amount : $this->amount;
    }

    public function getGrantedAmountAttribute(): Money
    {
        return Money::parseByDecimal(
            number_format((float) $this->projects()->sum('amount'), 2, '.', ''),
            $this->currency
        );
    }

    public function getRemainingAmountAttribute(): Money
    {
        return $this->grantable_amount->subtract($this->granted_amount);
    }

    public function getDonorsWithAmountsAttribute()
    {
        return $this->donors->map(fn (Donor $donor) => [
            'id'     => $donor->id,
            'amount' => $donor->contribution->amount->toInteger(),
        ]);
    }

    public function getDonorsWithFormattedAmountsAttribute()
    {
        return $this->donors->map(fn (Donor $donor) => [
            'name'   => $donor->name,
            'amount' => $donor->contribution->amount->formatWithoutDecimals(),
        ]);
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

    public function scopeWithYear(Builder $query): Builder
    {
        return $query
            ->selectRaw('YEAR(`start_date`) as `year`');
    }
}
