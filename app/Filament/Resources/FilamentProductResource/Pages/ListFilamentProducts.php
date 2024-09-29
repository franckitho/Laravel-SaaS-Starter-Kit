<?php

namespace App\Filament\Resources\FilamentProductResource\Pages;

use App\Filament\Resources\FilamentProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFilamentProducts extends ListRecords
{
    protected static string $resource = FilamentProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
