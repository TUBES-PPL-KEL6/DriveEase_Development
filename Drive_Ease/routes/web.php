<?php

use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RentalVehicleController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;
use Illuminate\Support\Facades\Route;

// 🔐 Redirect root ke login
Route::get('/', fn () => redirect('/login'));
use App\Http\Controllers\RentController;
use App\Http\Controllers\RentalRentController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🔐 Redirect default ke dashboard sesuai role
Route::get('/dashboard', fn () => redirect()->route('dashboard.redirect'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔄 Redirect user ke dashboard berdasarkan role
Route::get('/redirect', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'rental' => redirect()->route('rental.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->middleware('auth')->name('dashboard.redirect');

// 🔧 Halaman pengaturan profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===========================
// 🚗 Umum: Daftar & detail kendaraan
// ===========================
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');


// ===========================
// 👤 Pelanggan Routes
// ===========================
Route::middleware(['auth', IsPelanggan::class])->group(function () {
    Route::get('/user/dashboard', fn () => view('dashboard.user'))->name('user.dashboard');

    // Pemesanan kendaraan
    Route::post('/bookings/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
});


// ===========================
// 🚘 Rental Routes
// ===========================
Route::middleware(['auth', 'isRental'])->prefix('rental')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.rental'))->name('rental.dashboard');

    // Manajemen kendaraan oleh rental
    Route::get('/vehicles', [RentalVehicleController::class, 'index'])->name('rental.vehicles.index');
    Route::get('/vehicles/create', [RentalVehicleController::class, 'create'])->name('rental.vehicles.create');
    Route::post('/vehicles', [RentalVehicleController::class, 'store'])->name('rental.vehicles.store');

    // edit/delete 
    Route::get('/vehicles/{id}/edit', [RentalVehicleController::class, 'edit'])->name('rental.vehicles.edit');
    Route::put('/vehicles/{id}', [RentalVehicleController::class, 'update'])->name('rental.vehicles.update');
    Route::delete('/vehicles/{id}', [RentalVehicleController::class, 'destroy'])->name('rental.vehicles.destroy');

});


// ===========================
// 🛠️ Admin Routes
// ===========================
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', fn () => view('dashboard.admin'))->name('admin.dashboard');

    // TODO: Manajemen user, verifikasi booking, dll.
});


require __DIR__.'/auth.php';
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

    // Pelanggan
    Route::get('/user/rents', [RentController::class, 'index'])->name('rents.index');
    Route::get('/user/rents/{id}', [RentController::class, 'show'])->name('rents.show');
    Route::post('/user/rents', [RentController::class, 'store'])->name('rents.store');

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

    // Review
    Route::get('/review', [CarController::class, 'reviewPage'])->name('cars.review');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

});


require __DIR__ . '/auth.php';
