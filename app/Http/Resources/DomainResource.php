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
        switch ($request->route()->getName()) {
            case 'domains.show':
                return $this->getShowAttributes($request);
                break;

            case 'domains.edit':
                return $this->getEditAttributes($request);
                break;

            default:
                return $this->getIndexAttributes($request);
                break;
        }
    }

    public function getIndexAttribute($request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'parent_id'    => $this->parent_id,
        ];
    }

    public function getEditAttributes($requests): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'parent_id'    => $this->parent_id,
            'translations' => $this->translations->map->only('name', 'locale'),
        ];
    }

    public function getShowAttributes($requests): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'parent_id' => $this->parent_id,

            'donors_count'  => $this->donors->count(),
            'total_funding' => $this->total_funding->formatWithoutDecimals(),

            'parent_domains' => $this->parent_domains,

            'can'       => $this->getResourcePermissions(),
        ];
    }
}
