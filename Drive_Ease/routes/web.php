<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BookingController,
    CarController,
    CheckoutController,
    NotificationController,
    PaymentHistoryController,
    ProfileController,
    RentController,
    RentalRentController,
    RentalVehicleController,
    ReviewController,
    VehicleController
};
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;

// ===========================
// 🔐 Akses Umum
// ===========================
Route::get('/', fn() => view('landing'));

Route::get('/dashboard', fn() => redirect()->route('dashboard.redirect'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/redirect', function () {
    $role = auth()->user()->role;
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'rental' => redirect()->route('rental.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->middleware('auth')->name('dashboard.redirect');

// ===========================
// 🔧 Pengaturan Profil
// ===========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===========================
// 🚗 Umum: Kendaraan & Pencarian
// ===========================
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');

// ===========================
// 👤 Pelanggan
// ===========================
Route::middleware(['auth', IsPelanggan::class])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [BookingController::class, 'Booking_Dashboard'])->name('dashboard');

    // Pemesanan
    Route::get('/rents', [RentController::class, 'index'])->name('rents.index');
    Route::get('/rents/{id}', [RentController::class, 'show'])->name('rents.show');
    Route::post('/rents', [RentController::class, 'store'])->name('rents.store');
    Route::post('/rents/{id}/reject', [RentController::class, 'rejectRent'])->name('rents.reject');
    Route::post('/rents/{id}/confirm', [RentController::class, 'reConfirm'])->name('rents.reConfirm');

    // Booking
    Route::post('/bookings/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
    Route::get('/bookings/history', [BookingController::class, 'myBookings']);
});

// ===========================
// 🚘 Rental
// ===========================
Route::middleware(['auth', 'isRental'])->prefix('rental')->name('rental.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\RentalDashboardController::class, 'index'])->name('dashboard');

    // Kendaraan
    Route::resource('vehicles', RentalVehicleController::class)->except(['show']);

    // Pemesanan
    Route::get('/rents', [RentalRentController::class, 'index'])->name('rents.index');
    Route::get('/rents/{id}', [RentalRentController::class, 'show'])->name('rents.show');
    Route::post('/rents/{id}/confirm', [RentalRentController::class, 'confirmRent'])->name('rents.confirm');
    Route::post('/rents/{id}/reject', [RentalRentController::class, 'rejectRent'])->name('rents.reject');
});

// ===========================
// 🛠️ Admin
// ===========================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('dashboard');

    // Histori pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.index');

    // Approve dan Cancel Booking
    Route::post('/booking/{id}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// ===========================
// 💳 Checkout & Pembayaran
// ===========================
Route::post('/payment/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/return', [CheckoutController::class, 'returnToDashboard'])->name('checkout.return');

Route::prefix('payment-history')->name('payment_history.')->group(function () {
    Route::get('/create', [PaymentHistoryController::class, 'create'])->name('create');
    Route::post('/store', [PaymentHistoryController::class, 'store'])->name('store');
});

// ===========================
// 🔔 Notifikasi
// ===========================
Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/fetch', [NotificationController::class, 'fetchNotifications'])->name('fetch');
    Route::get('/count', [NotificationController::class, 'countNotification'])->name('count');
    Route::post('/store', [NotificationController::class, 'store'])->name('store');
    Route::post('/markAsRead', [NotificationController::class, 'markAsRead'])->name('markAsRead');
});

// ===========================
// ⭐ Review
// ===========================
Route::get('/review', [CarController::class, 'reviewPage'])->name('cars.review');
Route::resource('reviews', ReviewController::class)->except(['index', 'show', 'create']);

// 🔐 Auth
require __DIR__ . '/auth.php';
