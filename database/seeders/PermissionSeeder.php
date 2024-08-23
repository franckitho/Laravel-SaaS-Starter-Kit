<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissionsFilament = [
            'filament.user-filament.view-any',
            'filament.user-filament.view',
            'filament.user-filament.create',
            'filament.user-filament.update',
            'filament.user-filament.delete',
            'filament.user-filament.restore',
            'filament.user-filament.force-delete',
            'filament.user.view-any',
            'filament.user.view',
            'filament.user.create',
            'filament.user.update',
            'filament.user.delete',
            'filament.user.restore',
            'filament.user.force-delete',
        ];

        foreach ($permissionsFilament as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'filament']
            );
        }

        $roles = [
            'filament.admin',
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role, 'guard_name' => 'filament']
            );
        }

        // Attribuer les permissions aux rôles
        $rolePermissions = [
            'filament.admin' => [
                'filament.user-filament.view-any',
                'filament.user-filament.view',
                'filament.user-filament.create',
                'filament.user-filament.update',
                'filament.user-filament.delete',
                'filament.user-filament.restore',
                'filament.user-filament.force-delete',
                'filament.user.view-any',
                'filament.user.view',
                'filament.user.create',
                'filament.user.update',
                'filament.user.delete',
                'filament.user.restore',
                'filament.user.force-delete',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::findByName($roleName, 'filament');
            $role->syncPermissions($permissions);
        }
    }
}