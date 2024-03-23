<?php

namespace App\Filament\Resources\UserFilamentResource\Pages;

use App\Filament\Resources\UserFilamentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserFilaments extends ListRecords
{
    protected static string $resource = UserFilamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
