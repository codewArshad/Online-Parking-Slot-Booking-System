<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ParkingSlotController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BookingController::class, 'userDashboard'])->name('user.dashboard');

    Route::get('/book-slot', [BookingController::class, 'showAvailableSlots'])->name('user.book-slot');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('user.bookings');
    Route::put('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/slots', [ParkingSlotController::class, 'index'])->name('slots.index');
    Route::get('/slots/create', [ParkingSlotController::class, 'create'])->name('slots.create');
    Route::post('/slots', [ParkingSlotController::class, 'store'])->name('slots.store');
    Route::get('/slots/{slot}/edit', [ParkingSlotController::class, 'edit'])->name('slots.edit');
    Route::put('/slots/{slot}', [ParkingSlotController::class, 'update'])->name('slots.update');
    Route::delete('/slots/{slot}', [ParkingSlotController::class, 'destroy'])->name('slots.destroy');

    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings.index');
});
