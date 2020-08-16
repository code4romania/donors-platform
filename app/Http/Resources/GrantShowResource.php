<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\DomainResource;
use App\Http\Resources\ProjectResource;
use Cknow\Money\Money;
use Illuminate\Http\Resources\Json\JsonResource;

class GrantShowResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'domain'           => DomainResource::make($this->domain),
            'amount'           => $this->formatted_amount,
            'currency'         => $this->currency,
            'projects'         => ProjectResource::collection($this->grantees),

            'donors'           => $this->donors->pluck('name', 'id'),
            'grantees'         => $this->grantees->unique()->count(),
            'total_value'      => $this->total_value,

            'published_status' => $this->published_status,
        ];
    }
}
