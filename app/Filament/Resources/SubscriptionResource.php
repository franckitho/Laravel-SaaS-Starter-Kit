<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Laravel\Cashier\Subscription;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\SubscriptionResource\Pages;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static bool $softDeletes = true;

    protected static ?string $modelLabel = 'Subscriptions';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Billings Management';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('user.name'),
                TextColumn::make('stripe_id')
                    ->badge()
                    ->color('info'),
                TextColumn::make('stripe_status')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('stripe_price')
                    ->badge()
                    ->color('info'),
                TextColumn::make('quantity'),
                TextColumn::make('end_at')
                    ->dateTime()

            ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
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
            'index' => Pages\ListSubscriptions::route('/'),
        ];
    }
}
