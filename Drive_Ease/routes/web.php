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
<<<<<<< Updated upstream
    MidtransController,
    RentalDashboardController
    RentalRentController,
    AdminDashboardController

=======
    MidtransController
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream

Route::middleware(['auth', IsPelanggan::class])->prefix('user')->name('user.')->group(function () {
=======
    Route::middleware(['auth', IsPelanggan::class])->prefix('user')->name('user.')->group(function () {
>>>>>>> Stashed changes

    Route::get('/dashboard', fn() => view('dashboard.user'))->name('dashboard');
    Route::get('/rents', [RentController::class, 'index'])->name('rents.index');
    Route::get('/rents/{id}', [RentController::class, 'show'])->name('rents.show');
    Route::post('/rents', [RentController::class, 'store'])->name('rents.store');
    Route::post('/rents/{id}/reject', [RentController::class, 'rejectRent'])->name('rents.reject');
    Route::post('/rents/{id}/confirm', [RentController::class, 'reConfirm'])->name('rents.reConfirm');
    Route::get('/dashboard', [BookingController::class, 'Booking_Dashboard'])->name('dashboard.user');
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
    Route::get('/dashboard', [BookingController::class, 'Booking_Dashboard'])->name('dashboard');

    // Dashboard
    Route::get('/payment-status', [BookingController::class, 'PaymentStatus'])->name('payment.status')->middleware('auth');
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
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
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Transaction Management
    Route::get('/transactions', [App\Http\Controllers\Admin\AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{rental}', [App\Http\Controllers\Admin\AdminTransactionController::class, 'show'])->name('transactions.show');

    // Riwayat pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.index');
    Route::get('/payment-report', PaymentReportTable::class)->name('payment.report');
    Route::get('/transaction-report', \App\Livewire\Admin\TransactionReportTable::class)->name('transaction.report');
});
require __DIR__ . '/auth.php';

// ===========================
// 🚘 Rental Routes
// ===========================
Route::middleware(['auth', 'isRental'])->prefix('rental')->name('rental.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.rental'))->name('dashboard');

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
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('dashboard');

    // Lihat histori pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.index');
<<<<<<< Updated upstream
=======
});

require __DIR__ . '/auth.php';


// ===========================
// 🛠️ Admin Routes
// ===========================
    Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('dashboard');

    // Lihat histori pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('admin.payment.index');
>>>>>>> Stashed changes

    // Approve dan Reject Status
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
    Route::get('/dashboard', [CheckoutController::class, 'Dashboard'])->name('dashboard');
    Route::get('/payment/finish', [CheckoutController::class, 'finish'])->name('payment.finish');
<<<<<<< Updated upstream
Route::post('/payment/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/return', [CheckoutController::class, 'returnToDashboard'])->name('checkout.return');
=======
>>>>>>> Stashed changes

Route::post('/payment/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/return', [CheckoutController::class, 'returnToDashboard'])->name('checkout.return');

Route::prefix('payment-history')->name('payment_history.')->group(function () {
    Route::get('/create', [PaymentHistoryController::class, 'create'])->name('create');
    Route::post('/store', [PaymentHistoryController::class, 'store'])->name('store');
});

// ===========================
// 🔔 Notifikasi
// ===========================
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
    Route::get('/notifications/fetch', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');
    Route::get('/notifications/count', [NotificationController::class, 'countNotification'])->name('notifications.count');
    Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
<<<<<<< Updated upstream

Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/fetch', [NotificationController::class, 'fetchNotifications'])->name('fetch');
    Route::get('/count', [NotificationController::class, 'countNotification'])->name('count');
    Route::post('/store', [NotificationController::class, 'store'])->name('store');
    Route::post('/markAsRead', [NotificationController::class, 'markAsRead'])->name('markAsRead');
});

=======
>>>>>>> Stashed changes

// ===========================
// ⭐ Review
// ===========================
<<<<<<< Updated upstream

Route::get('/review', [CarController::class, 'reviewPage'])->name('cars.review');

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
=======
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
>>>>>>> Stashed changes

Route::resource('reviews', ReviewController::class)->except(['index', 'show', 'create']);

// 🔐 Auth
require __DIR__ . '/auth.php';