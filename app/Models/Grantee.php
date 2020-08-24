<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Grant;
use App\Traits\Filterable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Grantee extends Model
{
    use Filterable,
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

    public function grants()
    {
        return $this->belongsToMany(Grant::class, 'projects')
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
}
