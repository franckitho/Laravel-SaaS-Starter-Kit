<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use App\Models\Filament\UserFilament;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserFilamentResource\Pages;
use Filament\Infolists\Components\Section as SectionComponent;
use App\Filament\Resources\UserFilamentResource\RelationManagers;

class UserFilamentResource extends Resource
{
    protected static ?string $model = UserFilament::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static bool $softDeletes = true;

    protected static ?string $modelLabel = 'Users filament';

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
                TextColumn::make('created_at')
                    ->label('Created')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->sortable(),
            ])->defaultSort('id', 'desc')
            ->filters([
               
            ])
            ->actions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton()->color('gray'),
                ActionGroup::make([
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
                TextEntry::make('email'),
                TextEntry::make('created_at'),
                TextEntry::make('updated_at'),
            ]),
            SectionComponent::make([
                ViewEntry::make('')
                    ->view('infolists.components.user-filament-role')
            ]),
            SectionComponent::make([
                ViewEntry::make('')
                    ->view('infolists.components.user-filament-permission')
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
            'index' => Pages\ListUserFilaments::route('/'),
            'create' => Pages\CreateUserFilament::route('/create'),
            'view' => Pages\ViewUserFilament::route('/{record}'),
            'edit' => Pages\EditUserFilament::route('/{record}/edit'),
        ];
    }
}
