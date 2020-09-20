<?php

declare(strict_types=1);

namespace App\Http\Resources;

class GrantResource extends Resource
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
            case 'grants.index':
                return $this->getIndexAttributes($request);
                break;

            case 'donors.show':
            case 'managers.show':
                return $this->getListingAttributes($request);
                break;

            case 'grants.edit':
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
            'id'                => $this->id,
            'name'              => $this->name,
            'donors'            => $this->donors->pluck('name'),
            'domains'           => $this->domains->pluck('name'),
            'amount'            => $this->amount->formatWithoutDecimals(),
            'regranting_amount' => $this->regranting_amount->formatWithoutDecimals(),
            'start_date'        => $this->formatted_start_date,
            'end_date'          => $this->formatted_end_date,
            'published_status'  => $this->published_status,
        ];
    }

    public function getListingAttributes($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'domains'           => $this->domains->pluck('name'),
            'amount'            => $this->amount->formatWithoutDecimals(),
            'regranting_amount' => $this->regranting_amount->formatWithoutDecimals(),
            'start_date'        => $this->formatted_start_date,
            'end_date'          => $this->formatted_end_date,
            'published_status'  => $this->published_status,
        ];
    }

    public function getEditAttributes($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'translations'      => $this->translations,

            'domains'           => DomainResource::collection($this->domains),
            'amount'            => $this->amount,
            'currency'          => $this->currency,

            'donors'            => $this->donors->pluck('name', 'id'),
            'project_count'     => $this->project_count,
            'grantees'          => $this->grantees->pluck('name', 'id'),
            'funding_value'     => $this->funding_value,

            'published_status'  => $this->published_status,

            'start_date'        => $this->formatted_start_date,
            'end_date'          => $this->formatted_end_date,

            'manager'           => $this->managers->first()->id ?? null,
            'regranting_amount' => $this->regranting_amount,
            'matching'          => $this->matching,
        ];
    }

    public function getShowAttributes($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,

            'domains'           => $this->domains->pluck('name'),
            'amount'            => $this->amount->formatWithoutDecimals(),

            'donors'            => $this->donors->pluck('name', 'id'),
            'project_count'     => $this->project_count,
            'grantees'          => $this->grantees->unique()->count(),

            'published_status'  => $this->published_status,

            'start_date'        => $this->formatted_start_date,
            'end_date'          => $this->formatted_end_date,

            'can'               => $this->getResourcePermissions(),
        ];
    }
}
