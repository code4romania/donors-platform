<?php

declare(strict_types=1);

namespace App\Http\Resources;

class DomainResource extends Resource
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
            'parent_id'    => $this->parent_id,
            'translations' => $this->translations->map->only('name', 'locale'),
        ];
    }
}
