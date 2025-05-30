<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BookingController,
    CarController,
    CheckoutController,
    NotificationController,
    PaymentHistoryController,
    ProfileController,
    RentalVehicleController,
    ReviewController,
    VehicleController,
    DriverController,
    RentalBookingController,
    RentalRentController
};
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;
use App\Livewire\Admin\PaymentReportTable;

// ===========================
// 🔐 Akses Umum
// ===========================
Route::get('/', fn() => view('landing'));

// Redirect ke dashboard sesuai role
Route::get('/dashboard', fn () => redirect()->route('dashboard.redirect'))
    ->middleware(['auth', 'verified'])->name('dashboard');

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

    // Pemesanan (Rents)
    Route::get('/rents', [\App\Http\Controllers\RentController::class, 'index'])->name('rents.index');
    Route::get('/rents/{id}', [\App\Http\Controllers\RentController::class, 'show'])->name('rents.show');
    Route::post('/rents', [\App\Http\Controllers\RentController::class, 'store'])->name('rents.store');
    Route::post('/rents/{id}/reject', [\App\Http\Controllers\RentController::class, 'rejectRent'])->name('rents.reject');
    Route::post('/rents/{id}/confirm', [\App\Http\Controllers\RentController::class, 'reConfirm'])->name('rents.reConfirm');

    // Booking
    Route::post('/bookings/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
    Route::get('/my-bookings/{id}', [BookingController::class, 'myBookingsShow'])->name('bookings.show');
    Route::post('/my-bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/my-bookings/{id}/confirm', [BookingController::class, 'reConfirm'])->name('bookings.reConfirm');

    // Booking Driver
    Route::post('/drivers/available/{vehicle}', [DriverController::class, 'getAvailDriver'])->name('drivers.available');
    Route::get('/bookings/history', [BookingController::class, 'myBookings']);
});

// ===========================
// 🚘 Rental
// ===========================
Route::middleware(['auth', IsRental::class])->prefix('rental')->name('rental.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\RentalDashboardController::class, 'index'])->name('dashboard');

    // Kendaraan
    Route::resource('vehicles', RentalVehicleController::class)->except(['show']);

    // Pemesanan (Booking)
    Route::get('/bookings', [RentalBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [RentalBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/confirm', [RentalBookingController::class, 'confirmBooking'])->name('bookings.confirm');
    Route::post('/bookings/{id}/reject', [RentalBookingController::class, 'rejectBooking'])->name('bookings.reject');

    // Driver Management
    Route::resource('drivers', DriverController::class);
});

// ===========================
// 🛠️ Admin
// ===========================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.admin'))->name('dashboard');

    // Riwayat pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.index');
    Route::get('/payment-report', PaymentReportTable::class)->name('payment.report');
    Route::get('/transaction-report', \App\Livewire\Admin\TransactionReportTable::class)->name('transaction.report');

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
