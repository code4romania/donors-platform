<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Grant;
use App\Models\Grantee;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Project extends Pivot
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount'     => MoneyCast::class . ':currency',
        'start_date' => 'date',
        'end_date'   => 'date',
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
