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
            case 'domains.show':
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
            'manager'           => optional($this->manager)->name,
            'primary_domain'    => optional($this->primaryDomain->first())->name,
            'secondary_domains' => $this->secondaryDomains->pluck('name'),
            'grantees'          => $this->grantees->pluck('name')->join(', '),
            'amount'            => $this->amount->formatWithoutDecimals(),
            'converted_amount'  => $this->converted_amount->formatWithoutDecimals(),
            'regranting_amount' => optional($this->regranting_amount)->formatWithoutDecimals(),
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
            'primary_domain'    => optional($this->primaryDomain->first())->name,
            'secondary_domains' => $this->secondaryDomains->pluck('name'),
            'amount'            => $this->amount->formatWithoutDecimals(),
            'regranting_amount' => optional($this->regranting_amount)->formatWithoutDecimals(),
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

            'primary_domain'    => optional($this->primaryDomain->first())->id,
            'secondary_domains' => $this->secondaryDomains->pluck('id'),

            'amount'            => $this->amount->toInteger(),
            'currency'          => $this->currency,

            'donors'            => $this->donors_with_amounts,
            'project_count'     => $this->project_count,
            'grantees'          => $this->grantees->pluck('name', 'id'),
            'funding_value'     => $this->funding_value,

            'published_status'  => $this->published_status,

            'start_date'        => $this->formatted_start_date,
            'end_date'          => $this->formatted_end_date,

            'manager'           => optional($this->manager)->id,
            'regranting_amount' => optional($this->regranting_amount)->toInteger(),
            'matching'          => $this->matching,

            'can'               => $this->getResourcePermissions(),
        ];
    }

    public function getShowAttributes($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,

            'primary_domain'    => optional($this->primaryDomain->first())->name,
            'secondary_domains' => $this->secondaryDomains->pluck('name'),

            'amount'            => $this->amount->formatWithoutDecimals(),
            'regranting_amount' => optional($this->regranting_amount)->formatWithoutDecimals(),
            'operational_costs' => optional($this->operational_costs)->formatWithoutDecimals(),
            'remaining_amount'  => $this->remaining_amount->formatWithoutDecimals(),

            'donors'            => $this->donors_with_formatted_amounts,
            'project_count'     => $this->project_count,
            'project_slots'     => $this->project_count - $this->projects()->count(),
            'manager'           => optional($this->manager)->name,
            'grantees'          => $this->grantees->unique()->count(),

            'published_status'  => $this->published_status,

            'start_date'        => $this->formatted_start_date,
            'end_date'          => $this->formatted_end_date,

            'can'               => $this->getResourcePermissions(),
        ];
    }
}
