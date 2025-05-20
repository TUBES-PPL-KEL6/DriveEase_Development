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
    ReviewModerationController,
    RentalReviewController,
    AdminController,
    AdminUserController,
    AdminReviewController,
    CustomerReviewController,
    VehicleController
};
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;

// ===========================
// 🔐 Akses Umum
// ===========================

Route::get('/', fn () => view('landing'));

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
    Route::get('/dashboard', fn () => view('dashboard.user'))->name('dashboard');
    Route::get('/rents', [RentController::class, 'index'])->name('rents.index');
    Route::get('/rents/{id}', [RentController::class, 'show'])->name('rents.show');
    Route::post('/rents', [RentController::class, 'store'])->name('rents.store');

    Route::post('/bookings/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
});


// ===========================
// 🚘 Rental
// ===========================

Route::middleware(['auth', IsRental::class])->prefix('rental')->name('rental.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.rental'))->name('dashboard');

    Route::resource('vehicles', RentalVehicleController::class)->except(['show']);

    Route::get('/rents', [RentalRentController::class, 'index'])->name('rents.index');
    Route::get('/rents/{id}', [RentalRentController::class, 'show'])->name('rents.show');
    Route::post('/rents/{id}/confirm', [RentalRentController::class, 'confirmRent'])->name('rents.confirm');
    Route::post('/rents/{id}/reject', [RentalRentController::class, 'rejectRent'])->name('rents.reject');

    Route::get('/reviews', [RentalReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{vehicle}', [RentalReviewController::class, 'show'])->name('reviews.show');
});


// ===========================
// 🛠️ Admin
// ===========================

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment.index');

    Route::get('/reviews/reported', [ReviewModerationController::class, 'index'])->name('reviews.reported');
    Route::post('/reviews/{review}/approve', [ReviewModerationController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [ReviewModerationController::class, 'remove'])->name('reviews.remove');

    Route::resource('users', AdminUserController::class);
    Route::get('/config', [AdminController::class, 'config'])->name('config');
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/vehicles-reviews', [\App\Http\Controllers\AdminReviewController::class, 'vehiclesReviews'])->name('vehicles.reviews');
});


// ===========================
// 💳 Pembayaran
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

// Terkait Kendaraan
Route::middleware('auth')->group(function () {
    Route::post('/vehicles/{vehicle}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/vehicles/{vehicle}/reviews', [ReviewController::class, 'showVehicleReviews'])->name('reviews.vehicle');
});

// Halaman Review Kendaraan (Umum)
Route::get('/review', [CarController::class, 'reviewPage'])->name('cars.review');

// CRUD Review
Route::middleware('auth')->group(function () {
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/report', [ReviewModerationController::class, 'report'])->name('reviews.report');
    Route::get('/owner/reviews', [ReviewController::class, 'ownerDashboard'])->name('reviews.owner_dashboard');
});

// Customer-to-customer reviews
Route::middleware('auth')->group(function () {
    Route::post('/rents/{rent}/customer-review', [CustomerReviewController::class, 'store'])->name('customer-reviews.store');
    Route::get('/users/{user}/customer-reviews', [CustomerReviewController::class, 'index'])->name('customer-reviews.index');
});


// ===========================
// 🔐 Auth Routes
// ===========================

require __DIR__ . '/auth.php';
