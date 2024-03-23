<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->iconButton()->icon('heroicon-o-eye')->color('gray'),
            ActionGroup::make([
                Action::make('Login as user')
                    ->url(fn (User $record) => route('login-as-user', $record))
                    ->color('gray')
                    ->extraAttributes([
                        'target' => '_blank',
                    ]),
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
