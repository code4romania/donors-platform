<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\Filterable;
use App\Traits\Sortable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Filterable,
        HasFactory,
        LogsActivity,
        Notifiable,
        ReceivesWelcomeNotification,
        Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'locale', 'role',
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
        'role'              => UserRole::class,
    ];

    /**
     * @var string[]
     */
    public $searchable = [
        'id', 'name', 'email',
    ];

    /**
     * The attributes that are filterable.
     *
     * @var string[]
     */
    protected $filterable = [
        'role',
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
        //
    ];

    public function scopeWithRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    public function isAdmin(): bool
    {
        return $this->role->equals(UserRole::admin());
    }

    public function isDonor(): bool
    {
        return $this->role->equals(UserRole::donor());
    }

    public function isManager(): bool
    {
        return $this->role->equals(UserRole::manager());
    }

    public function organization()
    {
        return $this->morphTo();
    }

    public function grants()
    {
        return $this->organization->grants();
    }

    public function associateOrganization(?string $organization_id)
    {
        if ($this->role->equals(UserRole::admin()) || ! $organization_id) {
            $this->organization()->dissociate();
        } elseif ($this->role->equals(UserRole::donor())) {
            $this->organization()->associate(
                Donor::find($organization_id)
            );
        } elseif ($this->role->equals(UserRole::manager())) {
            $this->organization()->associate(
                GrantManager::find($organization_id)
            );
        }

        $this->save();
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
}
