<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Driver\DashboardController as DriverDashboardController;
use App\Http\Controllers\Passenger\DashboardController as PassengerDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Registration routes
Route::get('/register/passenger', [RegisterController::class, 'showPassengerForm'])->name('register.passenger');
Route::post('/register/passenger', [RegisterController::class, 'registerPassenger'])->name('register.passenger.store');
Route::get('/register/driver', [RegisterController::class, 'showDriverForm'])->name('register.driver');
Route::post('/register/driver', [RegisterController::class, 'registerDriver'])->name('register.driver.store');

// Dashboard redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isDriver()) {
        return redirect()->route('driver.dashboard');
    } elseif ($user->isPassenger()) {
        return redirect()->route('passenger.dashboard');
    }
    
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'manageUsers'])->name('users.index');
    Route::get('/drivers', [AdminDashboardController::class, 'manageDrivers'])->name('drivers.index');
    Route::patch('/drivers/{driver}/approve', [AdminDashboardController::class, 'approveDriver'])->name('drivers.approve');
    Route::patch('/drivers/{driver}/reject', [AdminDashboardController::class, 'rejectDriver'])->name('drivers.reject');
});

// Driver routes
Route::middleware(['auth', 'role:driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/create', [DriverDashboardController::class, 'createProfile'])->name('profile.create');
    Route::post('/profile', [DriverDashboardController::class, 'storeProfile'])->name('profile.store');
    Route::patch('/toggle-availability', [DriverDashboardController::class, 'toggleAvailability'])->name('toggle.availability');
});

// Passenger routes
Route::middleware(['auth', 'role:passenger'])->prefix('passenger')->name('passenger.')->group(function () {
    Route::get('/dashboard', [PassengerDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/profile', [PassengerDashboardController::class, 'updateProfile'])->name('profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
