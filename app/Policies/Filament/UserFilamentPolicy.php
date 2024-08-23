<?php

namespace App\Policies\Filament;

use Illuminate\Auth\Access\Response;
use App\Models\Filament\UserFilament;
use App\Models\User;

class UserFilamentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserFilament $user): bool
    {
        return $user->checkPermissionTo('filament.user-filament.view-any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserFilament $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('filament.user-filament.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserFilament $user): bool
    {
        return $user->checkPermissionTo('filament.user-filament.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('filament.user-filament.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('filament.user-filament.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('filament.user-filament.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Mixed $user, UserFilament $userfilament): bool
    {
        return $user->checkPermissionTo('filament.user-filament.force-delete');
    }
}
