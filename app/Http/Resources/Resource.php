<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Resource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = null;

    protected function getResourcePermissions(): array
    {
        return [
            'update' => Auth::user()->can('update', $this->resource),
            'delete' => Auth::user()->can('delete', $this->resource),
        ];
    }
}
