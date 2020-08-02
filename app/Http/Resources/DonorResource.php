<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonorResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'type'          => $this->type,
            'hq'          => $this->hq,
            'contact'     => $this->contact,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'focus_areas' => $this->focusAreas->map->only('id', 'name'),
        ];
    }
}