<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Laravel\Cashier\Subscription;
use Filament\Tables\Actions\Action;
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
                /* TextColumn::make('trial_ends_at')
                    ->dateTime('m/d/y H:i'), */
                TextColumn::make('ends_at')
                    ->dateTime('m/d/y H:i'),
                TextColumn::make('created_at')
                    ->dateTime('m/d/y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Invoice')
                    ->label('')
                    ->icon('heroicon-o-document')
                    ->action(function(Subscription $subscription) {
                        $pdf = $subscription->invoice()->download([
                            'vendor'    => config('cashier.invoices.information.vendor'),
                            'product'   => config('cashier.invoices.information.product'),
                            'street'    => config('cashier.invoices.information.street'),
                            'location'  => config('cashier.invoices.information.location'),
                            'phone'     => config('cashier.invoices.information.phone'),
                            'email'     => config('cashier.invoices.information.email'),
                            'url'       => config('cashier.invoices.information.url'),
                            'vendorVat' => config('cashier.invoices.information.vendorVat'),
                        ]);
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf;
                        }, 'invoice_' . $subscription->stripe_price . '.pdf');
                    }),
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
