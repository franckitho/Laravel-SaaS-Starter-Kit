<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Carbon\Carbon;

class UserWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('users', User::count())
                ->label('Users')
                ->description('New users that have joined')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->chart($this->getDataChart())
                ->color('success')
                ->icon('heroicon-o-user-group'),
        ];
    }

    public function getDataChart(): array
    {
        $counts = User::selectRaw('COUNT(*) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count')
            ->toArray();
        
        $counts = array_pad($counts, -6, 0);
        
        return array_values($counts);
    }
}
