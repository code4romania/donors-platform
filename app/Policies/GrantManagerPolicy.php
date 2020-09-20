<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\GrantManager;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GrantManagerPolicy
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
     * @param  \App\Models\User         $user
     * @param  \App\Models\GrantManager $manager
     * @return mixed
     */
    public function view(User $user, GrantManager $manager)
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
     * @param  \App\Models\User         $user
     * @param  \App\Models\GrantManager $manager
     * @return mixed
     */
    public function update(User $user, GrantManager $manager)
    {
        return $user->managers->contains($manager);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\GrantManager $manager
     * @return mixed
     */
    public function delete(User $user, GrantManager $manager)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\GrantManager $manager
     * @return mixed
     */
    public function restore(User $user, GrantManager $manager)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\GrantManager $manager
     * @return mixed
     */
    public function forceDelete(User $user, GrantManager $manager)
    {
        return false;
    }
}