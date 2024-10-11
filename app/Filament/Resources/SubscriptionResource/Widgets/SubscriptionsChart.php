<?php

namespace App\Filament\Resources\SubscriptionResource\Widgets;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Subscription;

class SubscriptionsChart extends ChartWidget
{
    protected static ?string $heading = 'Evolutions of Subscriptions';

    protected static ?string $maxHeight = '150px';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $startDate = match ($activeFilter) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfYear(), // Default to last year if no filter is selected
        };

        $endDate = Carbon::now();

        $trend = Trend::model(Subscription::class)
            ->between($startDate, $endDate);

        switch ($activeFilter) {
            case 'today':
                $trend = $trend->perHour();
                break;
            case 'week':
                $trend = $trend->perDay();
                break;
            case 'month':
                $trend = $trend->perDay();
                break;
            case 'year':
                $trend = $trend->perMonth();
                break;
            default:
                $trend = $trend->perMonth();
                break;
        }

        $data = $trend->count();

        $labels = $data->map(fn (TrendValue $value) => match ($activeFilter) {
            'today' => Carbon::parse($value->date)->format('H:i'),
            'week', 'month' => Carbon::parse($value->date)->format('d M'),
            'year' => Carbon::parse($value->date)->format('M'),
            default => Carbon::parse($value->date)->format('M'),
        })->toArray();

        $values = $data->map(fn (TrendValue $value) => $value->aggregate)->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Subscriptions',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'year' => 'This year',
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
