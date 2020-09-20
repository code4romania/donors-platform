<?php

declare(strict_types=1);

namespace App\Http\Resources;

class GrantManagerResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        switch ($request->route()->getName()) {
            case 'managers.index':
                return $this->getIndexAttributes($request);
                break;

            case 'managers.edit':
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
            'id'               => $this->id,
            'name'             => $this->name,
            'domains'          => $this->domains->pluck('name'),
            'published_status' => $this->published_status,
            'total_funding'    => $this->total_funding->formatWithoutDecimals(),
            'grant_count'      => $this->grant_count,
            'grantee_count'    => $this->grantee_count,
        ];
    }

    public function getShowAttributes($request): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'hq'               => $this->hq,
            'contact'          => $this->contact,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'domains'          => $this->domains->map->only('id', 'name'),
            'logo'             => $this->logo,
            'published_status' => $this->published_status,
            'total_funding'    => $this->total_regranting->formatWithoutDecimals(),
            'grant_count'      => $this->grant_count,
            'grant_domains'    => DomainResource::collection($this->grant_domains),
            'grantee_count'    => $this->grantee_count,

            'can'              => $this->getResourcePermissions(),
        ];
    }

    public function getEditAttributes($request): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'hq'               => $this->hq,
            'contact'          => $this->contact,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'domains'          => $this->domains->map->only('id', 'name'),
            'logo'             => $this->logo,
            'published_status' => $this->published_status,
        ];
    }
}
