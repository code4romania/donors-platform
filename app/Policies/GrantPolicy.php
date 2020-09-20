<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Grant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GrantPolicy
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
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant $grant
     * @return mixed
     */
    public function view(User $user, Grant $grant)
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
        return $user->donors->isNotEmpty();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant $grant
     * @return mixed
     */
    public function update(User $user, Grant $grant)
    {
        return $user->grants(['donors', 'managers'])->pluck('id')->contains($grant->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant $grant
     * @return mixed
     */
    public function delete(User $user, Grant $grant)
    {
        return $user->grants('donors')->pluck('id')
            ->contains($grant->id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant $grant
     * @return mixed
     */
    public function restore(User $user, Grant $grant)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant $grant
     * @return mixed
     */
    public function forceDelete(User $user, Grant $grant)
    {
        return false;
    }
}
