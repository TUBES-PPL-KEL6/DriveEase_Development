<?php
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
    MidtransController,
    RentalRentController,
    RentalDashboardController,
    RentalReviewController,
    FlaggedReviewController
};
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;
use App\Livewire\Admin\PaymentReportTable;
use App\Http\Controllers\Admin\UserController;

// ===========================
// 🔐 Akses Umum
// ===========================
Route::get('/', fn() => view('landing'));

// Redirect ke dashboard sesuai role
Route::get('/dashboard', fn() => redirect()->route('dashboard.redirect'))
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

    // Booking History
    Route::get('/history', [BookingController::class, 'history'])->name('history');
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

    // Reviews
    Route::resource('reviews', \App\Http\Controllers\RentalReviewController::class)->except(['show']);

    // Flagged Reviews
    Route::post('/reviews/flag', [FlaggedReviewController::class, 'store'])->name('reviews.flag');

    // Rental History
    Route::get('/history', [\App\Http\Controllers\Rental\BookingController::class, 'history'])->name('history');
    Route::get('/bookings/export', [\App\Http\Controllers\Rental\BookingController::class, 'export'])->name('bookings.export');
});

// ===========================
// 🛠️ Admin
// ===========================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Transaction Management
    Route::get('/transactions', [App\Http\Controllers\Admin\AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{rental}', [App\Http\Controllers\Admin\AdminTransactionController::class, 'show'])->name('transactions.show');

    // Riwayat pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.index');
    Route::get('/payment-report', PaymentReportTable::class)->name('payment.report');
    Route::get('/transaction-report', \App\Livewire\Admin\TransactionReportTable::class)->name('transaction.report');

    // Approve dan Cancel Booking
    Route::post('/booking/{id}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // User Management
    Route::resource('users', UserController::class);
});

// ===========================
// 💳 Checkout & Pembayaran
// ===========================

Route::get('/checkout', [CheckoutController::class, 'index'])->name('index');
Route::post('/checkout', [CheckoutController::class, 'index'])->name('index');
Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->name('user.show');
Route::get('/checkout/{id}', [CheckoutController::class, 'payment'])->name('user.show');
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler']);
Route::get('/dashboard/user', [CheckoutController::class, 'Dashboard'])->name('user.dashboard.user');
//Route::get('/dashboard', [CheckoutController::class, 'Dashboard'])->name('dashboard');
Route::get('/payment/finish', [CheckoutController::class, 'finish'])->name('payment.finish');
Route::post('/payment/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/return', [CheckoutController::class, 'returnToDashboard'])->name('checkout.return');

Route::post('/payment/checkout', [CheckoutController::class, 'index'])->name('checkout');
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

Route::post('/rental/reviews/{booking}', [RentalReviewController::class, 'store'])->name('rental.reviews.store');

// 🔐 Auth
require __DIR__ . '/auth.php';
