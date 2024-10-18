<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Gate;
use App\Models\Filament\UserFilament;
use App\Policies\Filament\UserPolicy;
use Illuminate\Support\ServiceProvider;
use App\Policies\Filament\UserFilamentPolicy;
use Filament\Tables\Columns\TextColumn;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(UserFilament::class, UserFilamentPolicy::class);

        TextColumn::configureUsing(function (TextColumn $textColumn) {
            $textColumn->placeholder('-');
        });
        Cashier::calculateTaxes();
    }
}
