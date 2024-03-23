<?php

namespace App\Filament\Resources\UserFilamentResource\Pages;

use App\Filament\Resources\UserFilamentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserFilament extends CreateRecord
{
    protected static string $resource = UserFilamentResource::class;
}
