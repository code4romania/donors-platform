<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Cknow\Money\Money;

class ProjectResource extends Resource
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
            case 'grants.show':
                return $this->getIndexAttributes($request);
                break;

            case 'grantees.show':
                return $this->getGranteeAttributes($request);
                break;

            default:
                return $this->getShowAttributes($request);
                break;
        }
    }

    public function getIndexAttributes($request): array
    {
        return [
            'id'         => $this->id,
            'grantees'   => $this->grantees->pluck('name'),
            'title'      => $this->title,
            'start_date' => $this->formatted_start_date,
            'end_date'   => $this->formatted_end_date,
            'amount'     => $this->amount->formatWithoutDecimals(),
        ];
    }

    public function getGranteeAttributes($request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'grant_id'   => $this->grant->id,
            'grant'      => $this->grant->name,
            'start_date' => $this->formatted_start_date,
            'end_date'   => $this->formatted_end_date,
            'amount'     => $this->amount->formatWithoutDecimals(),
        ];
    }

    public function getShowAttributes($request): array
    {
        return [
            'id'         => $this->id,
            'grant'      => $this->grant->only('id', 'name'),
            'grantees'   => $this->grantees->pluck('name', 'id'),
            'title'      => $this->title,
            'start_date' => $this->formatted_start_date,
            'end_date'   => $this->formatted_end_date,
            'amount'     => $this->amount->toInteger(),
            'currency'   => $this->currency,
            'max_amount' => Money::max(
                $this->grant->remaining_amount->subtract($this->amount),
                Money::parseByDecimal('0.00', $this->currency)
            ),

            'can'        => $this->getResourcePermissions(),
        ];
    }
}
