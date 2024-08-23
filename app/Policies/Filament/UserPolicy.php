<?php

namespace App\Policies\Filament;

use App\Models\User;

use Illuminate\Auth\Access\Response;
use App\Models\Filament\UserFilament;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserFilament $user): bool
    {
        return $user->checkPermissionTo('filament.user.view-any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserFilament $user, User $model): bool
    {
        return $user->checkPermissionTo('filament.user.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserFilament $user): bool
    {
        return $user->checkPermissionTo('filament.user.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('filament.user.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('filament.user.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('filament.user.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Mixed $user, User $model): bool
    {
        return $user->checkPermissionTo('filament.user.force-delete');
    }
}
