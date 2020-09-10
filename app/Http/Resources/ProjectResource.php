<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Cknow\Money\Money;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
    public function toArray($request): array
    {
        if ($request->route()->getName() === 'grants.show') {
            return $this->getIndexAttributes($request);
        }

        return $this->getShowAttributes($request);
    }

    public function getIndexAttributes($request): array
    {
        return [
            'id'         => $this->id,
            'grantee'    => $this->grantee->only('id', 'name'),
            'title'      => $this->title,
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
            'grantee'    => $this->grantee->only('id', 'name'),
            'title'      => $this->title,
            'start_date' => $this->formatted_start_date,
            'end_date'   => $this->formatted_end_date,
            'amount'     => $this->amount->toInteger(),
            'currency'   => $this->currency,
            'max_amount' => Money::max(
                $this->grant->remaining_amount->subtract($this->amount),
                Money::parseByDecimal('0.00', $this->currency)
            ),
        ];
    }
}
