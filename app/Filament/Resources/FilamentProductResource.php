<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FilamentProduct;
use App\Models\Filament\Product;
use Filament\Resources\Resource;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ForceDeleteAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FilamentProductResource\Pages;
use App\Filament\Resources\FilamentProductResource\RelationManagers;

class FilamentProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static bool $softDeletes = true;

    protected static ?string $modelLabel = 'Subscription plans';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Billings Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('stripe_product_id')
                            ->columnSpan(7)
                            ->required(),
                        TextInput::make('name')
                            ->columnSpan(7)
                            ->required(),
                        TextInput::make('price')
                            ->numeric()
                            ->inputMode('decimal')
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
                TextColumn::make('stripe_product_id')
                    ->badge()
                    ->searchable()
                    ->color('gray'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->searchable()
                    ->badge()
                    ->color('danger')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->iconButton()->color('gray'),
                ActionGroup::make([
                    DeleteAction::make()->icon(null),
                    ForceDeleteAction::make()->icon(null),
                    RestoreAction::make()->icon(null)
                ])->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFilamentProducts::route('/'),
            'create' => Pages\CreateFilamentProduct::route('/create'),
            'edit' => Pages\EditFilamentProduct::route('/{record}/edit'),
        ];
    }
}
