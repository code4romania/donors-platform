<?php

declare(strict_types=1);

namespace App\Http\Resources;

class UserResource extends Resource
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
            case 'users.index':
                return $this->getIndexAttributes($request);
                break;

            default:
                return $this->getShowAttributes($request);
                break;
        }
    }

    public function getIndexAttributes($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'role'        => $this->role_name,
        ];
    }

    public function getShowAttributes($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'role'        => $this->role_name,
            'permissions' => $this->all_permissions,
            'donors'      => $this->donors->pluck('id'),
            'managers'    => $this->managers->pluck('id'),
        ];
    }
}
