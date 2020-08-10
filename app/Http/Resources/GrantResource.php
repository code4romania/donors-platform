<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GrantResource extends JsonResource
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
            'id'           => $this->id,
            'name'         => $this->name,
            'focus_area'   => $this->focusArea,
            'amount'       => $this->amount->format(),
        ];
    }
}
