<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GrantGranteeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name'       => $this->name,
            'start_date' => $this->pivot->start_date,
            'end_date'   => $this->pivot->end_date,
            'amount'     => $this->pivot->amount->format(),
            'domain'     => $this->pivot->domain,
        ];
    }
}
