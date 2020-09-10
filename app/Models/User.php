<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Sortable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Filterable,
        HasFactory,
        HasRoles,
        Notifiable,
        Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'locale',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    public $searchable = [
        'id', 'name', 'email',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var string[]
     */
    protected $sortable = [
        'name', 'role',
    ];

    public function getRoleNameAttribute(): ?string
    {
        $role = $this->roles->first();

        if (is_null($role)) {
            return null;
        }

        return $role->name;
    }

    public function scopeWithRole(Builder $query, string $role): Builder
    {
        return $query->whereHas('roles', fn ($q) => $q->where('name', $role));
    }

    public function getAllPermissionsAttribute(): array
    {
        return [
            'domains' => [
                'create' => $this->can('domains.create'),
                'edit'   => $this->can('domains.edit'),
                'delete' => $this->can('domains.delete'),
            ],
            'donors' => [
                'create' => $this->can('donors.create'),
                'edit'   => $this->can('donors.edit'),
                'delete' => $this->can('donors.delete'),
            ],
            'grants' => [
                'create' => $this->can('grants.create'),
                'edit'   => $this->can('grants.edit'),
                'delete' => $this->can('grants.delete'),
            ],
            'grantees' => [
                'create' => $this->can('grantees.create'),
                'edit'   => $this->can('grantees.edit'),
                'delete' => $this->can('grantees.delete'),
            ],
            'managers' => [
                'create' => $this->can('managers.create'),
                'edit'   => $this->can('managers.edit'),
                'delete' => $this->can('managers.delete'),
            ],
            'projects' => [
                'create' => $this->can('projects.create'),
                'edit'   => $this->can('projects.edit'),
                'delete' => $this->can('projects.delete'),
            ],
            'projects' => [
                'create' => $this->can('projects.create'),
                'edit'   => $this->can('projects.edit'),
                'delete' => $this->can('projects.delete'),
            ],
            'users' => [
                'create' => $this->can('users.create'),
                'edit'   => $this->can('users.edit'),
                'delete' => $this->can('users.delete'),
            ],
        ];
    }
}
