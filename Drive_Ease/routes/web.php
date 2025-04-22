<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return redirect()->route('dashboard.redirect');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/redirect', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif ($role === 'rental') {
        return redirect('/rental/dashboard');
    } else {
        return redirect('/user/dashboard');
    }
})->middleware('auth')->name('dashboard.redirect');


Route::middleware(['auth'])->group(function () {
    // User
    Route::get('/user/dashboard', fn() => view('dashboard.user'))->name('user.dashboard');

    // Rental
    Route::get('/rental/dashboard', fn() => view('dashboard.rental'))->name('rental.dashboard');

    // Admin
    Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
});

Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');

Route::middleware(['auth', IsAdmin::class])->get('/admin/dashboard', fn () => view('dashboard.admin'));
Route::middleware(['auth', IsRental::class])->get('/rental/dashboard', fn () => view('dashboard.rental'));
Route::middleware(['auth', IsPelanggan::class])->get('/user/dashboard', fn () => view('dashboard.user'));


require __DIR__.'/auth.php';