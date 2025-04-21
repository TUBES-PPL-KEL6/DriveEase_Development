<?php

use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('landing');
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

    //checkout
    Route::post('/payment/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/return', [CheckoutController::class, 'returnToDashboard'])->name('checkout.return');
    Route::get('/payment-history/create', [PaymentHistoryController::class, 'create'])->name('payment_history.create');
    Route::post('/payment-history/store', [PaymentHistoryController::class, 'store'])->name('payment_history.store');
    // Route::get('/payment/checkout', [PaymentHistoryController::class, 'create'])->name('payment.checkout');

    // Rental
    Route::get('/rental/dashboard', fn() => view('dashboard.rental'))->name('rental.dashboard');

    // Admin
    Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');

    // Admin view payment_history
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->middleware('auth')->name('payment.index');

});


require __DIR__.'/auth.php';