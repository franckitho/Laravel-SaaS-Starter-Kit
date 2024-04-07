<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\ModelHasRole;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use App\Models\Filament\UserFilament;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListUserFilamentRole extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $entry;


    public function table(Table $table): Table
    {
        return $table
            ->query(ModelHasRole::query()->where('model_id', $this->entry))
            ->columns([
                TextColumn::make('roles.name'),
            ])
            ->paginated([5])
            ->filters([
                // ...
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('Revoke Role')
                        ->color('danger') 
                        ->action(function (ModelHasRole $record){
                            $user = UserFilament::find($record->role_id);
                            $user->removeRole($record->roles->name);
                        })
                        ->requiresConfirmation()
                ])->color('gray'),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('livewire.list-user-filament-permission');
    }
}