<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Exchange;
use App\Traits\Filterable;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Grantee extends Model
{
    use Filterable,
        HasRelationships,
        LogsActivity,
        Searchable,
        Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'tax_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'tax_id' => 'int',
    ];

    /**
     * The attributes that are filterable.
     *
     * @var string[]
     */
    protected $filterable = [
        'donors', 'managers',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var string[]
     */
    protected $sortable = [
        'name', 'donors_count', 'projects_count',
    ];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    protected $withCount = [
        //
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('withDonorsCount', function ($query) {
            return $query->withCount([
                'donors' => fn ($q) => $q->select(
                    DB::raw('count(distinct(`donors`.`id`))')
                ),
            ]);
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
            'tax_id',
        ];
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function grants()
    {
        return $this->projects()->with('grant');
    }

    public function donors(): HasManyDeep
    {
        return $this
            ->hasManyDeepFromRelations(
                $this->projects(),
                (new Project)->grant(),
                (new Grant)->donors(),
            )
            ->distinct();
    }

    public function managers(): HasManyDeep
    {
        return $this
            ->hasManyDeepFromRelations(
                $this->projects(),
                (new Project)->grant(),
                (new Grant)->manager(),
            )
            ->distinct();
    }

    public function getTotalFundingAttribute()
    {
        return Exchange::sumForCurrency(
            $this->projects()
                ->withGrantCurrency()
                ->withExchangeRates()
                ->get()
        );
    }

    public function setTaxIdAttribute($value): void
    {
        $this->attributes['tax_id'] = (int) preg_replace('/\D/', '', $value);
    }
}
