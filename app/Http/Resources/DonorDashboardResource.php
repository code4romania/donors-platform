<?php

declare(strict_types=1);

namespace App\Http\Resources;

class DonorDashboardResource extends Resource
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
            'id'               => $this->id,
            'name'             => $this->name,
            'type'             => $this->type,
            'grant_count'      => $this->grant_count,
            'domains'          => $this->domains->map->only('id', 'name'),
            'total_funding'    => $this->total_funding,
        ];
    }
}
