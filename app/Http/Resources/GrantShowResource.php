<?php

declare(strict_types=1);

namespace App\Http\Resources;

class GrantShowResource extends Resource
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
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'translations'      => $this->translations,

            'domains'           => DomainResource::collection($this->domains),
            'amount'            => $this->amount,
            'currency'          => $this->currency,

            'donors'            => $this->donors->pluck('name', 'id'),
            'project_count'     => $this->project_count,
            'grantees'          => $this->grantees->unique()->count(),
            'funding_value'     => $this->funding_value,

            'published_status'  => $this->published_status,

            'start_date'        => $this->formatted_start_date,
            'end_date'          => $this->formatted_end_date,

            'manager'           => $this->managers->first()->id ?? null,
            'regranting_amount' => $this->regranting_amount,
            'matching'          => $this->matching,
        ];
    }
}
