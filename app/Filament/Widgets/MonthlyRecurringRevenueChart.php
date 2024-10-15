<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Flowframe\Trend\TrendValue;
use App\Models\Filament\Product;
use Filament\Widgets\ChartWidget;
use Laravel\Cashier\Subscription;

class MonthlyRecurringRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Recurring Revenue (MRR) overwiew';

    protected static ?string $description = 'MMR takes into account only active subscription in a given month.';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $trend = Trend::model(Subscription::class)
            ->between(now()->subYear(), now());

        $trend = $trend->perMonth();

        $data = $trend->count();

        $labels = $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M'))->toArray();
        $this->getMonthlyRecurringRevenue(1);
       $values = [];
        for ($i = 12; $i >= 0; $i--) {
            $values[] = $this->getMonthlyRecurringRevenue($i);
        }

        return [
            'datasets' => [
                [
                    'label' => 'MRR',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    /**
     * Calculate the Monthly Recurring Revenue (MRR) for a given month offset.
     *
     * This method calculates the MRR by fetching the prices of products and the active users
     * who have subscriptions created in the specified month. It then multiplies the number of 
     * subscribed users by the price of each product to get the total revenue for each product 
     * and sums them up to get the MRR.
     *
     * @param int $monthOffset The number of months to offset from the current date to calculate the MRR. Default is 1.
     * @return string The formatted MRR in the specified currency and locale.
     */
    protected function getMonthlyRecurringRevenue(int $monthOffset = 0): string
    {
        $products = Product::pluck('price', 'stripe_product_id');
        $date = now()->subMonths($monthOffset);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $mrr = 0;

        $activeUsers = User::with(['subscriptions' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        }])->whereHas('subscriptions', function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        })->get();
        $products->each(function ($price, $stripeProductId) use (&$activeUsers, &$mrr) {
            $subscribedUsers = $activeUsers->filter(function ($user) use ($stripeProductId) {
                return $user->subscriptions->contains(function ($subscription) use ($stripeProductId) {
                    return $subscription->stripe_price === $stripeProductId;
                });
            });

            $userCount = $subscribedUsers->count();
            $totalRevenue = $userCount * $price;
            $mrr += $totalRevenue;
        });

        return $mrr;
    }

    protected function getType(): string
    {
        return 'line';
    }
}
