<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Grant;
use App\Models\Grantee;
use App\Traits\Filterable;
use App\Traits\HasDates;
use App\Traits\Sortable;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Filterable,
        HasDates,
        Sortable;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title', 'amount', 'currency', 'start_date', 'end_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'amount'     => MoneyCast::class . ':currency',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * @var string[]
     */
    public $searchable = [
        'id', 'title', 'grantee.name',
    ];

    /**
     * @var string[]
     */
    public $sortable = [
        'title', 'amount', 'start_date', 'end_date', 'grantee.name',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        'grantee',
    ];

    public function grant()
    {
        return $this->belongsTo(Grant::class);
    }

    public function grantee()
    {
        return $this->belongsTo(Grantee::class);
    }
}
