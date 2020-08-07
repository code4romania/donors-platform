<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Draftable;
use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    use Draftable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'amount', 'currency', 'start_date', 'end_date',
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
        return $this->belongsToMany(Grantee::class);
    }
}
