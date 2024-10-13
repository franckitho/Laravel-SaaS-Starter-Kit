<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use Flowframe\Trend\Trend;
use Laravel\Cashier\Cashier;
use Flowframe\Trend\TrendValue;
use Laravel\Cashier\Subscription;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardOverviewWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Stat::make('MRR', User::count())
                ->description('Increase')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                //->chart($this->getUserDataChart())
                ->color('success'),
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
}
