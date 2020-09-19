<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
        if ($user->can('projects.view')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Project $project
     * @return mixed
     */
    public function view(User $user, Domain $project)
    {
        if ($user->can('projects.view')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('projects.create')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Project $project
     * @return mixed
     */
    public function update(User $user, Domain $project)
    {
        if ($user->can('projects.edit')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Project $project
     * @return mixed
     */
    public function delete(User $user, Domain $project)
    {
        if ($user->can('projects.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Project $project
     * @return mixed
     */
    public function restore(User $user, Domain $project)
    {
        if ($user->can('projects.delete')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Project $project
     * @return mixed
     */
    public function forceDelete(User $user, Domain $project)
    {
        if ($user->can('projects.delete')) {
            return true;
        }
    }
}
