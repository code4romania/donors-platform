<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Grantee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GranteePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Grantee $grantee
     * @return mixed
     */
    public function view(User $user, Grantee $grantee)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role->equals(UserRole::analyst())) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Grantee $grantee
     * @return mixed
     */
    public function update(User $user, Grantee $grantee)
    {
        if ($user->role->equals(UserRole::analyst())) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Grantee $grantee
     * @return mixed
     */
    public function delete(User $user, Grantee $grantee)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Grantee $grantee
     * @return mixed
     */
    public function restore(User $user, Grantee $grantee)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Grantee $grantee
     * @return mixed
     */
    public function forceDelete(User $user, Grantee $grantee)
    {
        return false;
    }
}
