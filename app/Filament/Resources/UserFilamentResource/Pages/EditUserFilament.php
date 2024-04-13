<?php

namespace App\Filament\Resources\UserFilamentResource\Pages;

use Filament\Actions;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\UserFilamentResource;

class EditUserFilament extends EditRecord
{
    protected static string $resource = UserFilamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->iconButton()->icon('heroicon-o-eye')->color('gray'),
            ActionGroup::make([
                DeleteAction::make()->icon(null)
            ])->color('gray'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $mutatedData = $data;

        if ($mutatedData['password'] === null) {
            unset($mutatedData['password']);
        }
    
        return $mutatedData;
    }
}
