<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Tables\Columns\Text;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Split;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Infolists\Components\Section as SectionComponent;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->minLength(2)
                            ->maxLength(20)
                            ->columnSpan(7)
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->columnSpan(7)
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->autocomplete('new-password')
                            ->revealable()
                            ->columnSpan(7)
                            ->required(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('status')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->sortable(),
            ])->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton()->color('gray'),
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
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Success')
                                ->body('The user has been blocked successfully.')
                                ->icon('heroicon-o-check-circle'),
                        )
                        ->requiresConfirmation()
                        ->hidden(fn (User $record) => $record->status === 0)
                        ->color('danger'),
                    Action::make('Unblock user') 
                        ->action(function (User $record){
                            $record->status = 1;
                            $record->save();
                        })
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Success')
                                ->body('The user has been unblocked successfully.'),
                        ) 
                        ->requiresConfirmation()
                        ->hidden(fn (User $record) => $record->status === 1)
                        ->color('danger'),
                    DeleteAction::make()->icon(null)
                ])->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            SectionComponent::make([
                TextEntry::make('id'),
                TextEntry::make('name'),
                IconEntry::make('status')->boolean(),
                TextEntry::make('created_at'),
                TextEntry::make('updated_at'),
            ]),
            SectionComponent::make([
                
            ]),
        ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
