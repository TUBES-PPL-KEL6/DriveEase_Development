<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;
use Illuminate\Support\Facades\Route;

// 🔐 Redirect ke login
Route::get('/', fn () => redirect('/login'));

// 🔐 Redirect global ke dashboard sesuai role
Route::get('/dashboard', fn () => redirect()->route('dashboard.redirect'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔄 Redirect berdasarkan role setelah login/register
Route::get('/redirect', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => redirect('/admin/dashboard'),
        'rental' => redirect('/rental/dashboard'),
        default => redirect('/user/dashboard'),
    };
})->middleware('auth')->name('dashboard.redirect');

// 🔐 Profile edit/update
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 📦 VEHICLE ROUTES (umum / publik)
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');


// ===========================
// 👤 PELANGGAN (User) Routes
// ===========================
Route::middleware(['auth', IsPelanggan::class])->group(function () {
    Route::get('/user/dashboard', fn () => view('dashboard.user'))->name('user.dashboard');

    // Booking kendaraan
    Route::post('/bookings/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
});

// ===========================
// 🚘 RENTAL (Pemilik) Routes
// ===========================
Route::middleware(['auth', IsRental::class])->group(function () {
    Route::get('/rental/dashboard', fn () => view('dashboard.rental'))->name('rental.dashboard');

    // TODO: Tambahkan fitur rental manajemen kendaraan nanti
});

// ===========================
// 🛠️ ADMIN Routes
// ===========================
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', fn () => view('dashboard.admin'))->name('admin.dashboard');

    // TODO: Tambahkan fitur manajemen user/booking
});

require __DIR__.'/auth.php';
