<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Draftable;
use App\Traits\HasDates;
use App\Traits\Sortable;
use Cknow\Money\Money;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    use Draftable, HasDates, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'amount', 'currency', 'start_date', 'end_date', 'max_grantees', 'regranting_amount', 'matching',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var array
     */
    protected $sortable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date'        => 'date',
        'end_date'          => 'date',
        'published_at'      => 'datetime',
        'matching'          => 'boolean',
        'amount'            => MoneyCast::class . ':currency',
        'regranting_amount' => MoneyCast::class . ':currency',
    ];

    public function donors()
    {
        return $this->belongsToMany(Donor::class);
    }

    public function manager()
    {
        return $this->belongsTo(GrantManager::class, 'grant_manager_id');
    }

    public function grantees()
    {
        return $this->belongsToMany(Grantee::class, 'projects')
            ->using(Project::class)
            ->as('project')
            ->withPivot([
                'id',
                'title',
                'amount',
                'currency',
                'start_date',
                'end_date',
            ]);
    }

    public function projects()
    {
        return $this->grantees->pluck('project');
    }

    public function domains()
    {
        return $this->morphToMany(Domain::class, 'domainable');
    }

    public function getFormattedAmountAttribute(): ?string
    {
        if (! $this->amount) {
            return null;
        }

        return $this->amount->format();
    }

    public function getTotalValueAttribute()
    {
        return $this->grantees->pluck('project.amount')
            ->filter()
            ->unlessEmpty(
                fn ($amounts) => Money::sum(...$amounts),
                fn () => null,
            );
    }
}
