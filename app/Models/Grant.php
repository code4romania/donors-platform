<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Draftable;
use App\Traits\Sortable;
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
        'name', 'amount', 'currency', 'start_date', 'end_date',
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
        return $this->belongsToMany(Grantee::class);
    }

    public function focusArea()
    {
        return $this->belongsTo(FocusArea::class);
    }
}
