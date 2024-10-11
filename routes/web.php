<?php

use Inertia\Inertia;
use App\Actions\LoginAsUserAction;
use App\Http\Middleware\UserStatus;
use App\Http\Middleware\AuthFilament;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth', 'verified', UserStatus::class)->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('plans', [SubscriptionController::class, 'create'])->name('create');
        Route::post('process', [SubscriptionController::class, 'store'])->name('process');
        Route::delete('cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('resume', [SubscriptionController::class, 'resume'])->name('resume');
    });
});

Route::middleware('auth', UserStatus::class)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(AuthFilament::class)->group(function () {
    Route::get('/filament/login-as/{user}', LoginAsUserAction::class)->name('login-as-user');
});


require __DIR__.'/auth.php';
