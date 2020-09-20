<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Sortable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Filterable,
        HasFactory,
        HasRoles,
        Notifiable,
        Sortable,
        ReceivesWelcomeNotification;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'locale', 'permissions',
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

    /**
     * The relationships that should always be loaded.
     *
     * @var string[]
     */
    protected $with = [
        'donors', 'managers',
    ];

    public function scopeWithRole(Builder $query, string $role): Builder
    {
        return $query->whereHas('roles', fn ($q) => $q->where('name', $role));
    }

    /**
     * morphedByMany template.
     *
     * @param  string      $related
     * @return MorphToMany
     */
    private function relatedTo(string $related): MorphToMany
    {
        return $this->morphedByMany(
            $related,
            'model',
            'user_manages_model',
            'user_id',
            'model_id',
        );
    }

    public function managers()
    {
        return $this->relatedTo(GrantManager::class);
    }

    public function donors()
    {
        return $this->relatedTo(Donor::class);
    }

    public function getRoleNameAttribute(): ?string
    {
        $role = $this->roles->first();

        if (is_null($role)) {
            return null;
        }

        return $role->name;
    }

    public function getAllPermissionsAttribute(): array
    {
        return [
            'domains' => [
                'view'   => $this->can('viewAny', Domain::class),
                'create' => $this->can('create', Domain::class),
            ],
            'donors' => [
                'view'   => $this->can('viewAny', Donor::class),
                'create' => $this->can('create', Donor::class),
            ],
            'grants' => [
                'view'   => $this->can('viewAny', Grant::class),
                'create' => $this->can('create', Grant::class),
            ],
            'grantees' => [
                'view'   => $this->can('viewAny', Grantee::class),
                'create' => $this->can('create', Grantee::class),
            ],
            'managers' => [
                'view'   => $this->can('viewAny', GrantManager::class),
                'create' => $this->can('create', GrantManager::class),
            ],
            'projects' => [
                'view'   => $this->can('viewAny', Project::class),
                'create' => $this->can('create', Project::class),
            ],
            'users' => [
                'view'   => $this->can('viewAny', self::class),
                'create' => $this->can('create', self::class),
            ],
        ];
    }

    public function setPermissionsAttribute($values): void
    {
        $this->syncPermissions($values);
    }

    /**
     * Fetch a list of grants associated with the user's $relationships.
     *
     * @param  mixed                          $relationships
     * @return \Illuminate\Support\Collection
     */
    public function grants($relationships): Collection
    {
        return collect($relationships)
            ->map(
                fn (string $relationship) => $this->$relationship()
                    ->with(['grants' => fn ($q) => $q->withoutGlobalScopes()])
                    ->get()
                    ->pluck('grants')
                    ->flatten()
            )
            ->flatten()
            ->unique('id');
    }
}
