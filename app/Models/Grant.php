<?php

declare(strict_types=1);

namespace App\Models;

use App\Pivots\Project;
use App\Traits\Draftable;
use App\Traits\Sortable;
use Cknow\Money\Money;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    use Draftable, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'amount', 'currency',
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
        'published_at' => 'datetime',
        'amount' => MoneyCast::class . ':currency',
    ];

    public function donors()
    {
        return $this->belongsToMany(Donor::class);
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'grant_manager');
    }

    public function grantees()
    {
        return $this->belongsToMany(Grantee::class, 'projects')
            ->using(Project::class)
            ->as('project')
            ->withPivot([
                'title',
                'amount',
                'currency',
                'start_date',
                'end_date',
            ]);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
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
