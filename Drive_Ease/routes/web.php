<?php

use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
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


<<<<<<< Updated upstream
require __DIR__.'/auth.php';
=======
// ===========================
// 🚘 Rental Routes
// ===========================
Route::middleware(['auth', 'isRental'])->prefix('rental')->name('rental.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.rental'))->name('dashboard');

    // Kendaraan milik rental
    Route::get('/vehicles', [RentalVehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/create', [RentalVehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles', [RentalVehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{id}/edit', [RentalVehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehicles/{id}', [RentalVehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{id}', [RentalVehicleController::class, 'destroy'])->name('vehicles.destroy');

    // Pemesanan dari pelanggan
    Route::get('/rents', [RentalRentController::class, 'index'])->name('rents.index');
    Route::get('/rents/{id}', [RentalRentController::class, 'show'])->name('rents.show');
    Route::post('/rents/{id}/confirm', [RentalRentController::class, 'confirmRent'])->name('rents.confirm');
    Route::post('/rents/{id}/reject', [RentalRentController::class, 'rejectRent'])->name('rents.reject');
});


// ===========================
// 🛠️ Admin Routes
// ===========================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.admin'))->name('dashboard');

    // Lihat histori pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.index');

    // Approve dan Reject Status
    Route::post('/booking/{id}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
});


// ===========================
// 💳 Checkout & Pembayaran
// ===========================
Route::post('/payment/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/return', [CheckoutController::class, 'returnToDashboard'])->name('checkout.return');
Route::get('/payment-history/create', [PaymentHistoryController::class, 'create'])->name('payment_history.create');
Route::post('/payment-history/store', [PaymentHistoryController::class, 'store'])->name('payment_history.store');


// ===========================
// 🔔 Notifikasi
// ===========================
Route::get('/notifications/fetch', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');
Route::get('/notifications/count', [NotificationController::class, 'countNotification'])->name('notifications.count');
Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
Route::post('/notifications/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');


// ===========================
// ⭐ Ulasan / Review
// ===========================
Route::get('/review', [CarController::class, 'reviewPage'])->name('cars.review');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


// 🔐 Auth routes
require __DIR__ . '/auth.php';
>>>>>>> Stashed changes
