<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SaccoController;
use App\Http\Controllers\Driver\DashboardController as DriverDashboardController;
use App\Http\Controllers\Driver\TripController;
use App\Http\Controllers\Passenger\DashboardController as PassengerDashboardController;
use App\Http\Controllers\Api\RideSearchController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// API routes for ride search (public access, no CSRF)
Route::group(['prefix' => 'api'], function () {
    Route::get('/saccos', [RideSearchController::class, 'getSaccos']);
    Route::post('/search-rides', [RideSearchController::class, 'searchRides']);
    
    // Test route to check if trips exist
    Route::get('/test-trips', function() {
        $trips = \App\Models\Trip::with(['driver.user', 'sacco'])->take(5)->get();
        return response()->json([
            'success' => true,
            'count' => $trips->count(),
            'trips' => $trips
        ]);
    });
    
    // API routes for booking and payment (public access)
    Route::post('/initiate-booking', [PaymentController::class, 'initiateBooking']);
    Route::post('/check-payment-status', [PaymentController::class, 'checkPaymentStatus']);
    Route::post('/mpesa-callback', [PaymentController::class, 'mpesaCallback']);
    Route::get('/receipt/{booking}', [PaymentController::class, 'getReceipt']);
});
Route::get('/receipt/{booking}', [PaymentController::class, 'getReceiptView'])->name('receipt.view');

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
    
    // SACCO management routes
    Route::resource('saccos', SaccoController::class);
    
    // Trip management routes
    Route::resource('trips', \App\Http\Controllers\Admin\TripController::class);
    Route::patch('/trips/{trip}/status', [\App\Http\Controllers\Admin\TripController::class, 'updateStatus'])->name('trips.update-status');
});

// Driver routes
Route::middleware(['auth', 'role:driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
    Route::get('/completed-trips', [DriverDashboardController::class, 'getCompletedTrips'])->name('completed.trips');
    Route::get('/profile/create', [DriverDashboardController::class, 'createProfile'])->name('profile.create');
    Route::post('/profile', [DriverDashboardController::class, 'storeProfile'])->name('profile.store');
    Route::get('/profile/edit', [DriverDashboardController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile', [DriverDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/toggle-availability', [DriverDashboardController::class, 'toggleAvailability'])->name('toggle.availability');
    
    // Trip viewing and status management for drivers
    Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
    Route::patch('/trips/{trip}/accept', [TripController::class, 'acceptTrip'])->name('trips.accept');
    Route::patch('/trips/{trip}/start', [TripController::class, 'startTrip'])->name('trips.start');
    Route::patch('/trips/{trip}/complete', [TripController::class, 'completeTrip'])->name('trips.complete');
});

// Passenger routes
Route::middleware(['auth', 'role:passenger'])->prefix('passenger')->name('passenger.')->group(function () {
    Route::get('/dashboard', [PassengerDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/profile', [PassengerDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::match(['get', 'post'], '/search-rides', [PassengerDashboardController::class, 'searchRides'])->name('search.rides');
    Route::post('/book-ride/{trip}', [PassengerDashboardController::class, 'bookRide'])->name('book.ride');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
