<?php

namespace App\Filament\Resources\UserFilamentResource\Pages;

use App\Filament\Resources\UserFilamentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserFilament extends EditRecord
{
    protected static string $resource = UserFilamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
