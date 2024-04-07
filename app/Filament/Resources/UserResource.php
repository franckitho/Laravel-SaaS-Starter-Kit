<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Actions\ForceDeleteAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Section as SectionComponent;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static bool $softDeletes = true;

    protected static ?string $recordTitleAttribute = 'name'; 
    
    protected static ?string $navigationGroup = 'Users Management';
    
    
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
                        DateTimePicker::make('email_verified_at')
                            ->columnSpan(7),
                        TextInput::make('password')
                            ->password()
                            ->autocomplete('new-password')
                            ->revealable()
                            ->columnSpan(7),
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
                IconColumn::make('deleted_at')
                    ->label('')
                    ->icon(fn (User $user): string => $user->deleted_at === null ? '' : 'heroicon-o-trash')
                    ->color('danger')
                    ->wrap()
                    ->sortable(),
            ])->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('status')
                ->options([
                    0 => 'Blocked',
                    1 => 'Active',
                ]),
                Filter::make('deleted_at')
                    ->form([
                        Radio::make('deleted_at')
                        ->options([
                            null => 'Show all users',
                            'with_deleted' => 'Show only deleted users',
                            'without_deleted' => 'Hide deleted users'
                        ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if($data['deleted_at'] == 'with_deleted')
                        {
                            return $query->onlyTrashed();
                        }elseif($data['deleted_at'] == 'without_deleted')
                        {
                            return $query->withoutTrashed();
                        }
                        return $query;
                    })
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
                        ->hidden(fn (User $record) => !$record->status)
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
                        ->hidden(fn (User $record) => $record->status)
                        ->color('danger'),
                    DeleteAction::make()->icon(null),
                    ForceDeleteAction::make()->icon(null),
                    RestoreAction::make()->icon(null)
                ])->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            SectionComponent::make([
                TextEntry::make('id'),
                TextEntry::make('name'),
                TextEntry::make('email'),
                IconEntry::make('status')->boolean(),
                TextEntry::make('created_at'),
                TextEntry::make('updated_at'),
            ]),
            SectionComponent::make([
                ViewEntry::make('')
                    ->view('infolists.components.user-role')
            ]),
            SectionComponent::make([
                ViewEntry::make('')
                    ->view('infolists.components.user-permission')
            ])
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
