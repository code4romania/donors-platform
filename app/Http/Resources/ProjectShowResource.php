<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectShowResource extends JsonResource
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
        return [
            'id'         => $this->id,
            'grant'      => $this->grant_id,
            'grantee'    => $this->grantee_id,
            'title'      => $this->title,
            'start_date' => $this->formatted_start_date,
            'end_date'   => $this->formatted_end_date,
            'amount'     => floatval($this->amount->formatByDecimal()),
            'currency'   => $this->currency,
        ];
    }
}
