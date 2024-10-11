<?php

namespace App\Filament\Resources\SubscriptionResource\Widgets;

use Laravel\Cashier\Subscription;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SubscriptionsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Suscription', Subscription::count()),
            Stat::make('Active Subscription', Subscription::query()->active()->count()),
            Stat::make('Unique User Subscribed', Subscription::query()->distinct('user_id')->count()),
        ];
    }
}
