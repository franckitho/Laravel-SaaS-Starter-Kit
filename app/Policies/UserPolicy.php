<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Mixed $user): bool
    {
        return $user->checkPermissionTo('view-any User');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('view User');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Mixed $user): bool
    {
        return $user->checkPermissionTo('create User');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('update User');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('delete User');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('restore User');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('force-delete User');
    }
}
