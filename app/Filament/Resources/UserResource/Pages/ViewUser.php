<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;
use Spatie\Permission\Models\Permission;
use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\RelationManager\RoleRelationManager;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\RelationManager\PermissionRelationManager;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function getRelationManagers(): array
    {
        return [
            RoleRelationManager::class,
            PermissionRelationManager::class
        ];
    }
    
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->iconButton()->icon('heroicon-o-pencil-square')->color('gray'),
            ActionGroup::make([
                Action::make('Login as user')
                    ->url(fn (User $record) => route('login-as-user', $record))
                    ->color('gray')
                    ->extraAttributes([
                        'target' => '_blank',
                    ]),
                Action::make('Assign Role')
                    ->form([
                        Select::make('role')
                            ->label('Role')
                            ->options(fn (User $record) => Role::query()->where('guard_name', 'web')
                                ->whereNotIn('name', $record->roles->pluck('name'))
                                ->pluck('name', 'name'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data, User $record): void {
                        $record->assignRole($data['role']);
                    }),
                Action::make('Assign Permission')
                    ->form([
                        Select::make('permission')
                            ->label('Permission')
                            ->options(fn (User $record) => Permission::query()->where('guard_name', 'web')
                                ->whereNotIn('name', $record->permissions->pluck('name'))
                                ->pluck('name', 'name'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data, User $record): void {
                        $record->givePermissionTo($data['permission']);
                    }),
                Action::make('Block user') 
                    ->action(function (User $record){
                        $record->status = 0;
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->hidden(fn (User $record) => $record->status === 0)
                    ->color('danger'),
                Action::make('Unblock user') 
                    ->action(function (User $record){
                        $record->status = 1;
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->hidden(fn (User $record) => $record->status === 1)
                    ->color('danger'),
                DeleteAction::make()->icon(null)
            ])->color('gray'),
        ];
    }
    
}
