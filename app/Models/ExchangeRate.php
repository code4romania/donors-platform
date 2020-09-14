<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Str;

class ExchangeRate extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'currency_from', 'currency_to', 'rate', 'date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'rate' => 'float',
        'date' => 'date',
    ];

    public function setCurrencyFromAttribute($value)
    {
        $this->attributes['currency_from'] = Str::upper($value);
    }

    public function setCurrencyToAttribute($value)
    {
        $this->attributes['currency_to'] = Str::upper($value);
    }
}
