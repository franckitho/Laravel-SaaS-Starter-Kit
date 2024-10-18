<?php

use Inertia\Inertia;
use App\Actions\LoginAsUserAction;
use App\Http\Middleware\UserStatus;
use App\Http\Middleware\AuthFilament;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show');

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
    Route::get('user/invoice/{invoiceId}', InvoiceController::class)->name('invoices.download');
});

Route::middleware(AuthFilament::class)->group(function () {
    Route::get('/filament/login-as/{user}', LoginAsUserAction::class)->name('login-as-user');
});


require __DIR__.'/auth.php';
