<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\HasExchangeRates;
use App\Traits\Sortable;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Grantee extends Model
{
    use Filterable,
        HasExchangeRates,
        HasRelationships,
        Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var string[]
     */
    public $searchable = [
        'id', 'name',
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
        'donors', 'projects',
    ];

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
        return $this->sumForCurrency(
            $this->projects()
                ->withGrantCurrency()
                ->withExchangeRates()
                ->get()
        );
    }
}
