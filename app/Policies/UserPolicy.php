<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User $currentUser
     * @return mixed
     */
    public function viewAny(User $currentUser)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User $currentUser
     * @param  \App\User        $user
     * @return mixed
     */
    public function view(User $currentUser, User $user)
    {
        if ($currentUser->can('manage users')) {
            return true;
        }

        if ($currentUser->is($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $currentUser
     * @return mixed
     */
    public function create(User $currentUser)
    {
        if ($currentUser->can('manage users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User $currentUser
     * @param  \App\User        $user
     * @return mixed
     */
    public function update(User $currentUser, User $user)
    {
        if ($currentUser->can('manage users')) {
            return true;
        }

        if ($currentUser->is($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User $currentUser
     * @param  \App\User        $user
     * @return mixed
     */
    public function delete(User $currentUser, User $user)
    {
        if ($currentUser->can('manage users')) {
            return true;
        }

        if ($currentUser->is($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User $currentUser
     * @param  \App\User        $user
     * @return mixed
     */
    public function restore(User $currentUser, User $user)
    {
        if ($currentUser->can('manage users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User $currentUser
     * @param  \App\User        $user
     * @return mixed
     */
    public function forceDelete(User $currentUser, User $user)
    {
        if ($currentUser->can('manage users')) {
            return true;
        }
    }
}
