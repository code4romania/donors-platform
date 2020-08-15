<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Grantee extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var array
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
