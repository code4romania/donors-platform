<?php

declare(strict_types=1);

namespace App\Http\Resources;

class GranteeResource extends Resource
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
            case 'grantees.index':
                return $this->getIndexAttributes($request);
                break;

            case 'grantees.edit':
                return $this->getEditAttributes($request);
                break;

            default:
                return $this->getShowAttributes($request);
                break;
        }
    }

    public function getIndexAttributes($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'projects_count' => $this->projects_count,
            'donors_count'   => $this->donors_count,
        ];
    }

    public function getEditAttributes($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
        ];
    }

    public function getShowAttributes($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'projects_count' => $this->projects_count,
            'donors_count'   => $this->donors_count,
            'total_funding'  => $this->total_funding->formatWithoutDecimals(),

            'can'            => $this->getResourcePermissions(),
        ];
    }
}
