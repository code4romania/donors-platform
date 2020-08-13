<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'grantee'    => $this->name,
            'title'      => $this->project->title,
            'start_date' => $this->project->start_date,
            'end_date'   => $this->project->end_date,
            'amount'     => $this->project->amount->format(),
        ];
    }
}
