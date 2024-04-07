<?php

namespace App\Filament\Resources\UserFilamentResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Spatie\Permission\Models\Role;
use App\Models\Filament\UserFilament;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\UserFilamentResource;

class ViewUserFilament extends ViewRecord
{
    protected static string $resource = UserFilamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->iconButton()->icon('heroicon-o-pencil-square')->color('gray'),
            ActionGroup::make([
                Action::make('Assign Role')
                ->form([
                    Select::make('role')
                        ->label('Role')
                        ->options(fn (UserFilament $record) => Role::query()->where('guard_name', 'filament')
                            ->whereNotIn('name', $record->roles->pluck('name'))
                            ->pluck('name', 'name'))
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data, UserFilament $record): void {
                    $record->assignRole($data['role']);
                }),
                Action::make('Assign Permission')
                ->form([
                    Select::make('permission')
                        ->label('Permission')
                        ->options(fn (UserFilament $record) => Permission::query()->where('guard_name', 'filament')
                            ->whereNotIn('name', $record->permissions->pluck('name'))
                            ->pluck('name', 'name'))
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data, UserFilament $record): void {
                    $record->givePermissionTo($data['permission']);
                }),
                DeleteAction::make()->icon(null)
            ])->color('gray'),
        ];
    }
    
}
