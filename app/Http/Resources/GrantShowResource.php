<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\DomainResource;
use App\Http\Resources\ProjectIndexResource;
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
            'id'                => $this->id,
            'name'              => $this->name,
            'domains'           => DomainResource::collection($this->domains),
            'amount'            => $this->amount,
            'currency'          => $this->currency,

            'donors'            => $this->donors->pluck('name', 'id'),
            'max_grantees'      => $this->max_grantees,
            'grantees'          => $this->grantees->unique()->count(),
            'total_value'       => $this->total_value,

            'published_status'  => $this->published_status,

            'start_date'        => $this->formatted_start_date,
            'end_date'          => $this->formatted_end_date,

            'manager'           => $this->manager->id ?? null,
            'regranting_amount' => $this->regranting_amount,
            'matching'          => $this->matching,
        ];
    }
}
