<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Sortable;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Grantee extends Model
{
    use Filterable,
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
     * The attributes that are sortable.
     *
     * @var string[]
     */
    protected $sortable = [
        'name',
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

    public function getTotalFundingAttribute()
    {
        //
    }
}
