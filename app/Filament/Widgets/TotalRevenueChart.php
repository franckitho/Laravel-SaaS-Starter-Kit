<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Laravel\Cashier\Invoice;
use Illuminate\Support\Carbon;
use Flowframe\Trend\TrendValue;
use App\Models\Filament\Product;
use Filament\Widgets\ChartWidget;
use Laravel\Cashier\Subscription;
use Illuminate\Support\Collection;

class TotalRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Total Revenue overview';

    protected static ?string $description = 'Total revenue generated';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $values = [];
        $labels = [];

        for ($i = 11; $i >= 0; $i--) {
            $values[] = $this->getTotalRevenue($i);
            $labels[] = now()->subMonths($i)->format('Y-m');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Revenue',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    /**
     * Calculate the total revenue for a given month offset.
     *
     * This method calculates the total revenue by iterating through all users and their invoices,
     * summing up the invoice totals for the specified month. The month is determined by the 
     * provided offset from the current month.
     *
     * @param int $monthOffset The number of months to offset from the current month. Default is 0 (current month).
     * @return float The total revenue for the specified month, in dollars.
     */
    protected function getTotalRevenue(int $monthOffset = 0): float
    {
        $date = now()->subMonths($monthOffset);
        $total = 0;

        $users = User::all();

        $users->each(function ($user) use (&$total, $date) {
            $user->invoices()->each(function ($invoice) use (&$total, $date) {
                if (Carbon::parse($invoice->date())->isSameMonth($date)) {
                    $total += $invoice->total;
                }
            });
        });

        return $total / 100;
    }

    protected function getType(): string
    {
        return 'line';
    }
}
