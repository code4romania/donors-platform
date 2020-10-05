<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function __construct(Request $request)
    {
        $this->grant = $request->route('grant');
    }

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
     * @param  \App\Models\Project $project
     * @return mixed
     */
    public function view(User $user, Project $project)
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
        if ($user->role->equals(UserRole::donor())) {
            return true;
        }

        if (
            $this->grant !== null &&
            $this->grant->projects->count() < $this->grant->project_count
        ) {
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
    public function update(User $user, Project $project)
    {
        if (
            $this->grant !== null &&
            $this->grant->projects->pluck('id')->contains($project->id) &&
            $user->grants->pluck('id')->contains($this->grant->id)
        ) {
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
    public function delete(User $user, Project $project)
    {
        if (
            $this->grant !== null &&
            $this->grant->projects->pluck('id')->contains($project->id) &&
            $user->grants->pluck('id')->contains($this->grant->id)
        ) {
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
    public function restore(User $user, Project $project)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Project $project
     * @return mixed
     */
    public function forceDelete(User $user, Project $project)
    {
        return false;
    }
}
