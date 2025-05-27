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
    VehicleController,
    DriverController,
    RentalBookingController,
};
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;

// ===========================
// 🔐 Akses Umum
// ===========================

// Halaman awal redirect ke login
Route::get('/', function () {
    return view('landing');
});

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
// 👤 Pelanggan Routes
// ===========================
Route::middleware(['auth', IsPelanggan::class])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.user'))->name('dashboard');

    Route::get('/dashboard', [BookingController::class, 'Booking_Dashboard'])->name('dashboard.user');
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
    Route::get('/bookings', [RentalBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [RentalBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/confirm', [RentalBookingController::class, 'confirmBooking'])->name('bookings.confirm');
    Route::post('/bookings/{id}/reject', [RentalBookingController::class, 'rejectBooking'])->name('bookings.reject');

    // Driver
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/drivers/create', [DriverController::class, 'create'])->name('drivers.create');
    Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('/drivers/{driver}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::put('/drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
    Route::delete('/drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');

    // Driver Management Routes
    Route::resource('drivers', DriverController::class);
});

// ===========================
// 🛠️ Admin Routes
// ===========================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('dashboard');

    // Lihat histori pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.index');
});

require __DIR__ . '/auth.php';


// ===========================
// 🛠️ Admin Routes
// ===========================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('dashboard');

    // Lihat histori pembayaran
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('admin.payment.index');

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
