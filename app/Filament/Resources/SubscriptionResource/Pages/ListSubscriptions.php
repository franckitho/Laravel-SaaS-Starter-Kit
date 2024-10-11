<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SubscriptionResource;
use App\Filament\Resources\SubscriptionResource\Widgets\SubscriptionsChart;
use App\Filament\Resources\SubscriptionResource\Widgets\SubscriptionsOverview;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SubscriptionsOverview::class,
            SubscriptionsChart::class,
        ];
    }
}
