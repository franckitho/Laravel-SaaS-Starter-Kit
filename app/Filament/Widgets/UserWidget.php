<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use Flowframe\Trend\Trend;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Number;
use Flowframe\Trend\TrendValue;
use App\Models\Filament\Product;
use Laravel\Cashier\Subscription;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardOverviewWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Stat::make('MRR', $this->getMonthlyRecurringRevenueFormated())
                ->description($this->getLastMonthDiff())
                ->descriptionIcon($this->getMonthlyRecurringRevenueIcon())
                ->color($this->getMonthlyRecurringRevenueColor()),
            Stat::make('Active Subscription', Subscription::query()->active()->count()),
            Stat::make('Total Revenue', $this->getTotalRevenue()),
            Stat::make('Total user subscription conversion', $this->getConvertion())
                ->description('subscribed / total users'),
            Stat::make('Transaction', $this->getTransation())
                ->label('Total Transaction'),
            Stat::make('Users', User::count())
                ->label('Total Users')
        ];
    }

    /**
     * Calculate the total number of paid invoices for all users.
     *
     * This method retrieves all users and iterates through each user's invoices.
     * It counts the number of invoices that have a status of 'paid'.
     *
     * @return int The total number of paid invoices.
     */
    protected function getTransation(): int
    {
        $users = User::all();
        $total = 0;

        $users->each(function ($user) use (&$total) {
            $user->invoices()->each(function ($invoice) use (&$total) {
                if ($invoice->status == 'paid') {
                    $total++;
                }
            });
        });

        return $total;
    }
    /**
     * Calculate the conversion rate of users who have subscribed.
     *
     * This method retrieves the total number of users and the total number of unique subscribed users,
     * then calculates the conversion rate as a percentage.
     *
     * @return string The conversion rate formatted as a percentage with two decimal places.
     */
    protected function getConvertion(): string
    {
        $totalUser = User::count();
        $totalSubscribed = Subscription::query()->distinct('user_id')->count();

        return number_format(($totalSubscribed / $totalUser) * 100, 2) . '%';
    }

    /**
     * Calculate the total revenue from all users' invoices.
     *
     * This method retrieves all users and iterates through each user's invoices
     * to sum up the total revenue. The total amount is then formatted using the
     * Cashier::formatAmount method.
     *
     * @return string The formatted total revenue.
     */
    protected function getTotalRevenue(): string
    {
        $users = User::all();
        $total = 0;

        $users->each(function ($user) use (&$total) {
            $user->invoices()->each(function ($invoice) use (&$total) {
                $total += $invoice->total;
            });
        });

        return Cashier::formatAmount($total);
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

        $activeUsers = User::with('subscriptions')->whereHas('subscriptions', function ($query) use ($date) {
            $query->active()->with('subscriptions')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year);
        })->get();
        $products->each(function ($price, $stripeProductId) use (&$activeUsers, &$mrr) {

            $subscribedUsers = $activeUsers->filter(function ($user) use ($stripeProductId) {
                return $user->subscriptions->contains(function ($subscription) use ($stripeProductId) {
                    return $subscription->stripe_price === $stripeProductId;
                });
            });

            // Calculer le nombre d'utilisateurs abonnés à ce produit
            $userCount = $subscribedUsers->count();

            // Calculer le revenu total pour ce produit
            $totalRevenue = $userCount * $price;

            $mrr += $totalRevenue;
        });
        // Retourner le MRR formaté en devise
        return $mrr;
    }

    /**
     * Get the formatted Monthly Recurring Revenue (MRR) for a given month offset.
     *
     * This method retrieves the MRR for the specified month offset, formats it as a currency
     * string based on the application's currency and locale settings, and returns the formatted string.
     *
     * @param int $monthOffset The number of months to offset from the current month. Default is 0.
     * @return string The formatted MRR as a currency string.
     */
    protected function getMonthlyRecurringRevenueFormated(int $monthOffset = 0): string
    {
        return Number::currency($this->getMonthlyRecurringRevenue($monthOffset), config('cashier.currency'), config('app.locale'));
    }

    /**
     * Calculate the difference in Monthly Recurring Revenue (MRR) between the current month and the previous month.
     *
     * @return string The formatted currency difference between the current month's MRR and the previous month's MRR.
     */
    protected function getLastMonthDiff(): string {
        $diff = $this->getMonthlyRecurringRevenue() - $this->getMonthlyRecurringRevenue(1);

        return Number::currency($diff, config('cashier.currency'), config('app.locale')) . ' ' . ($diff > 0 ? 'increase' : 'decrease');
    }

    /**
     * Get the icon representing the monthly recurring revenue trend.
     *
     * This method returns an icon based on the difference in revenue from the last month.
     * If the revenue has increased, it returns an upward arrow icon.
     * If the revenue has decreased or stayed the same, it returns a downward arrow icon.
     *
     * @return string The icon class name indicating the revenue trend.
     */
    protected function getMonthlyRecurringRevenueIcon(): string
    {
        return $this->getLastMonthDiff() > 0  ? 'heroicon-o-arrow-up' : 'heroicon-o-arrow-down';
    }

    /**
     * Determines the color representation of the Monthly Recurring Revenue (MRR) based on the difference from the last month.
     *
     * @return string Returns 'success' if the MRR has increased compared to the last month, otherwise returns 'danger'.
     */
    protected function getMonthlyRecurringRevenueColor(): string
    {
        return $this->getLastMonthDiff() > 0  ? 'success' : 'danger';
    }
}
