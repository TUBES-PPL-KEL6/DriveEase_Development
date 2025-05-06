<?php

<<<<<<< HEAD
<<<<<<< HEAD
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\RentalRentController;
=======
>>>>>>> main
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
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

<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
// ===========================
// 🔐 Akses Umum
// ===========================

// Halaman awal redirect ke login
<<<<<<< HEAD
>>>>>>> main
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
Route::get('/', function () {
    return view('landing');
});

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
// 👤 Pelanggan Routes
// ===========================
Route::middleware(['auth', IsPelanggan::class])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.user'))->name('dashboard');
    Route::get('/rents', [RentController::class, 'index'])->name('rents.index');
    Route::get('/rents/{id}', [RentController::class, 'show'])->name('rents.show');
    Route::post('/rents', [RentController::class, 'store'])->name('rents.store');

<<<<<<< HEAD
<<<<<<< Updated upstream
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
    // Booking
    Route::post('/bookings/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
=======
    //checkout
    Route::get('/payment/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
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

    // Pelanggan
    Route::get('/user/rents', [RentController::class, 'index'])->name('rents.index');
    Route::get('/user/rents/{id}', [RentController::class, 'show'])->name('rents.show');
    Route::post('/user/rents', [RentController::class, 'store'])->name('rents.store');
    Route::post('/user/rents/{id}/reject', [RentController::class, 'rejectRent'])->name('rents.reject');
    Route::post('/user/rents/reConfirm', [RentController::class, 'reConfirm'])->name('rents.reConfirm');

    // Rental
    Route::get('/rental/rents', [RentalRentController::class, 'index'])->name('rental.rents.index');
    Route::get('/rental/rents/{id}', [RentalRentController::class, 'show'])->name('rental.rents.show');
    Route::post('/rental/rents/{id}/confirm', [RentalRentController::class, 'confirmRent'])->name('rental.rents.confirm');
    Route::post('/rental/rents/{id}/reject', [RentalRentController::class, 'rejectRent'])->name('rental.rents.reject');
    // Route::post('/rental/rents', [RentController::class, 'store'])->name('rents.store');

    Route::get('/notifications/fetch', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');
    Route::get('/notifications/count', [NotificationController::class, 'countNotification'])->name('notifications.count');
    Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
<<<<<<< HEAD
});


=======
>>>>>>> Stashed changes
});

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
<<<<<<< HEAD
>>>>>>> main
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
require __DIR__ . '/auth.php';
