<?php

declare(strict_types=1);

namespace App\Models;

use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Contribution extends Pivot
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'amount' => MoneyCast::class . ':grant_currency',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function grant()
    {
        return $this->belongsTo(Grant::class);
    }
}
