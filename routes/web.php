<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MyBookingsController;
use App\Http\Controllers\MyEventsController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/events');
})->name('home');

Route::get('/dashboard', function () {
    return redirect('/events');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class);
    Route::resource('bookings', BookingController::class);
    Route::get('/my-events', [MyEventsController::class, 'index'])->name('my-events');
    Route::get('/my-bookings', [MyBookingsController::class, 'index'])->name('my-bookings');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
