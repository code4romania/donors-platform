<?php

declare(strict_types=1);

namespace App\Models;

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

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function grants()
    {
        return $this->projects()->with('grant');
    }
}
