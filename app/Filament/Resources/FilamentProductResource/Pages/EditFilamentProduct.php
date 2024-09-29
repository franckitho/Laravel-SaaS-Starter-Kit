<?php

namespace App\Filament\Resources\FilamentProductResource\Pages;

use App\Filament\Resources\FilamentProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFilamentProduct extends EditRecord
{
    protected static string $resource = FilamentProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
