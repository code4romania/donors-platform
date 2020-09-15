<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GrantManagerResource extends JsonResource
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
    public function toArray($request)
    {
        if ($request->route()->getName() === 'managers.index') {
            return $this->getIndexAttributes($request);
        }

        return $this->getShowAttributes($request);
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
            'logo_url'         => $this->logo_url,
            'published_status' => $this->published_status,
            'total_funding'    => $this->total_funding->formatWithoutDecimals(),
            'grant_count'      => $this->grant_count,
            'grantee_count'    => $this->grantee_count,
        ];
    }
}
