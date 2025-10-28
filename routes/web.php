<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;

// -------------------------
// Redirect home to customer booking page
// -------------------------
Route::get('/', fn() => redirect('/customer'));

// -------------------------
// Default Breeze dashboard redirect after login
// -------------------------
Route::get('/dashboard', function () {
    // After login, redirect users to provider dashboard by default
    return redirect()->route('provider.dashboard');
})->middleware(['auth'])->name('dashboard');

// -------------------------
// Provider routes (for agents / consultants)
// -------------------------
Route::prefix('provider')->name('provider.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');
    Route::get('/availability', [AvailabilityController::class, 'index'])->name('availability');
    Route::post('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
    Route::get('/slots', [AvailabilityController::class, 'slots'])->name('slots');
});

// -------------------------
// Customer booking routes
// -------------------------
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/slots', [CustomerController::class, 'slots'])->name('customer.slots');
Route::post('/customer/book', [BookingController::class, 'store'])->name('customer.book');
Route::get('/customer/confirm/{booking}', [CustomerController::class, 'confirm'])->name('customer.confirm');

// -------------------------
// User profile (Breeze default)
// -------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------
// Auth routes (from Breeze)
// -------------------------
require __DIR__.'/auth.php';
