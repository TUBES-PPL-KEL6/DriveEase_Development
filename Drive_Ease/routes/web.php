<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
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


require __DIR__.'/auth.php';
