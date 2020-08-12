<?php

declare(strict_types=1);

namespace App\Http\Resources;

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
            'id'       => $this->id,
            'name'     => $this->name,
            'domain'   => $this->domain,
            'amount'   => $this->formatted_amount,
            'grantees' => GrantGranteeResource::collection($this->grantees),
            'stats'    => [
                'total_value' => Money::sum(...$this->grantees->pluck('pivot.amount')),
                'grantees'    => $this->grantees->count(),
            ],
        ];
    }
}
