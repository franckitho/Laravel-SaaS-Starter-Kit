<?php

namespace App\Filament\Resources\UserFilamentResource\Pages;

use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UserFilamentResource;

class ViewUserFilament extends ViewRecord
{
    protected static string $resource = UserFilamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->iconButton()->icon('heroicon-o-pencil-square')->color('gray'),
            ActionGroup::make([
                DeleteAction::make()->icon(null)
            ])->color('gray'),
        ];
    }
    
}
