<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RentalVehicleController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;
use Illuminate\Support\Facades\Route;

// 🔐 Redirect root ke login
Route::get('/', fn () => redirect('/login'));

// 🔐 Redirect default ke dashboard sesuai role
Route::get('/dashboard', fn () => redirect()->route('dashboard.redirect'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔄 Redirect user ke dashboard berdasarkan role
Route::get('/redirect', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'rental' => redirect()->route('rental.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->middleware('auth')->name('dashboard.redirect');

// 🔧 Halaman pengaturan profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===========================
// 🚗 Umum: Daftar & detail kendaraan
// ===========================
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');


// ===========================
// 👤 Pelanggan Routes
// ===========================
Route::middleware(['auth', IsPelanggan::class])->group(function () {
    Route::get('/user/dashboard', fn () => view('dashboard.user'))->name('user.dashboard');

    // Pemesanan kendaraan
    Route::post('/bookings/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
});


// ===========================
// 🚘 Rental Routes
// ===========================
Route::middleware(['auth', 'isRental'])->prefix('rental')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.rental'))->name('rental.dashboard');

    // Manajemen kendaraan oleh rental
    Route::get('/vehicles', [RentalVehicleController::class, 'index'])->name('rental.vehicles.index');
    Route::get('/vehicles/create', [RentalVehicleController::class, 'create'])->name('rental.vehicles.create');
    Route::post('/vehicles', [RentalVehicleController::class, 'store'])->name('rental.vehicles.store');

    // edit/delete 
    Route::get('/vehicles/{id}/edit', [RentalVehicleController::class, 'edit'])->name('rental.vehicles.edit');
    Route::put('/vehicles/{id}', [RentalVehicleController::class, 'update'])->name('rental.vehicles.update');
    Route::delete('/vehicles/{id}', [RentalVehicleController::class, 'destroy'])->name('rental.vehicles.destroy');

});


// ===========================
// 🛠️ Admin Routes
// ===========================
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', fn () => view('dashboard.admin'))->name('admin.dashboard');

    // TODO: Manajemen user, verifikasi booking, dll.
});


require __DIR__.'/auth.php';
