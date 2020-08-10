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
}
