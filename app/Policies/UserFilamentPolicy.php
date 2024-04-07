<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Filament\UserFilament;
use App\Models\User;

class UserFilamentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Mixed $user): bool
    {
        return $user->checkPermissionTo('view-any UserFilament');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('view UserFilament');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Mixed $user): bool
    {
        return $user->checkPermissionTo('create UserFilament');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('update UserFilament');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('delete UserFilament');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('restore UserFilament');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('force-delete UserFilament');
    }
}
