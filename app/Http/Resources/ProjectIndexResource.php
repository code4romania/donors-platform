<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectIndexResource extends JsonResource
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
            'grantee'    => $this->only('id', 'name'),
            'id'         => $this->project->id,
            'title'      => $this->project->title,
            'start_date' => $this->project->formatted_start_date,
            'end_date'   => $this->project->formatted_end_date,
            'amount'     => $this->project->amount,
            'currency'   => $this->project->currency,
        ];
    }
}
