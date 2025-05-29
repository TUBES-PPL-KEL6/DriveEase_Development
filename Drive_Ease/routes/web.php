<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BookingController,       // Digunakan untuk pelanggan dan beberapa aksi admin
    CarController,           // Mungkin untuk halaman review lama, bisa dievaluasi
    CheckoutController,
    NotificationController,
    PaymentHistoryController,
    ProfileController,
    RentalVehicleController, // Untuk manajemen kendaraan oleh rental
    ReviewController,
    VehicleController,       // Untuk tampilan kendaraan publik
    DriverController,        // Untuk manajemen driver oleh rental & ketersediaan untuk pelanggan
    RentalBookingController, // Untuk manajemen booking oleh rental
    RentalDashboardController, // Untuk dashboard rental
    // RentController,          // Di-comment karena kita standarisasi ke BookingController
    // RentalRentController,    // Di-comment karena kita standarisasi ke RentalBookingController
};
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsRental;
use App\Http\Middleware\IsPelanggan;
use App\Livewire\Admin\PaymentReportTable;
use App\Livewire\Admin\TransactionReportTable; // Pastikan namespace ini benar

// ===========================
// 🔐 Akses Umum
// ===========================
Route::get('/', fn() => view('landing'))->name('landing'); // Tambahkan name untuk referensi

Route::get('/dashboard', fn() => redirect()->route('dashboard.redirect'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/redirect', function () {
    $role = auth()->user()->role;
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'rental' => redirect()->route('rental.dashboard'),
        default => redirect()->route('user.dashboard'), // Pelanggan diarahkan ke user.dashboard
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
// Pastikan VehicleController@show ada dan parameter sesuai (id atau model binding dengan slug)
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show'); // Menggunakan {vehicle} untuk model binding jika pakai slug

// ===========================
// 👤 Pelanggan
// ===========================
Route::middleware(['auth', IsPelanggan::class])->prefix('user')->name('user.')->group(function () {
    // Dashboard pelanggan menampilkan daftar booking mereka
    Route::get('/dashboard', [BookingController::class, 'myBookings'])->name('dashboard');

    // Booking oleh Pelanggan
    Route::post('/bookings/{vehicle}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine'); // Alias untuk dashboard atau daftar booking
    Route::get('/my-bookings/{booking}', [BookingController::class, 'myBookingsShow'])->name('bookings.show'); // {booking} untuk model binding
    Route::post('/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel'); // Aksi pembatalan oleh user
    // Route::post('/my-bookings/{booking}/confirm', [BookingController::class, 'reConfirm'])->name('bookings.reConfirm'); // Re-confirm mungkin tidak umum untuk user

    // Cek Ketersediaan Driver
    Route::post('/drivers/available/{vehicle}', [DriverController::class, 'getAvailDriver'])->name('drivers.available');

    // Riwayat booking bisa jadi sama dengan myBookings
    Route::get('/bookings/history', [BookingController::class, 'myBookings'])->name('bookings.history');
});

// ===========================
// 🚘 Rental
// ===========================
Route::middleware(['auth', IsRental::class])->prefix('rental')->name('rental.')->group(function () {
    Route::get('/dashboard', [RentalDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Kendaraan oleh Rental
    Route::resource('vehicles', RentalVehicleController::class)->except(['show']); // Rental tidak punya halaman show publik, itu di VehicleController

    // Manajemen Booking yang Masuk ke Rental
    Route::get('/bookings', [RentalBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [RentalBookingController::class, 'show'])->name('bookings.show'); // {booking} untuk model binding
    Route::post('/bookings/{booking}/confirm', [RentalBookingController::class, 'confirmBooking'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/reject', [RentalBookingController::class, 'rejectBooking'])->name('bookings.reject');

    // Manajemen Driver oleh Rental
    Route::resource('drivers', DriverController::class); // Ini sudah mencakup index, create, store, edit, update, destroy, show (jika ada)
});

// ===========================
// 🛠️ Admin
// ===========================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('dashboard'); // Pastikan view ini ada

    // Laporan (Livewire)
    Route::get('/payment-report', PaymentReportTable::class)->name('payment.report');
    Route::get('/transaction-report', TransactionReportTable::class)->name('transaction.report');

    // Histori pembayaran (jika berbeda dari laporan)
    Route::get('/payment-history', [PaymentHistoryController::class, 'index'])->name('payment-history.index');

    // Approve dan Cancel/Reject Booking oleh Admin
    Route::post('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve'); // {booking} untuk model binding
    // Menggunakan `reject` untuk konsistensi dengan Rental
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject'); // Pastikan metode reject ada di BookingController untuk admin
});

// ===========================
// 💳 Checkout & Pembayaran
// ===========================
// Pastikan CheckoutController dan method-methodnya ada
Route::post('/payment/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/return', [CheckoutController::class, 'returnToDashboard'])->name('checkout.return'); // Kemana user diarahkan setelah pembayaran

// Jika payment history bisa dibuat manual (misal oleh admin)
Route::prefix('payment-history')->name('payment-history.')->group(function () { // Mengubah nama prefix agar konsisten
    Route::get('/create', [PaymentHistoryController::class, 'create'])->name('create')->middleware(['auth', IsAdmin::class]); // Hanya admin
    Route::post('/store', [PaymentHistoryController::class, 'store'])->name('store')->middleware(['auth', IsAdmin::class]);   // Hanya admin
});

// ===========================
// 🔔 Notifikasi
// ===========================
// Pastikan NotificationController dan method-methodnya ada
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/fetch', [NotificationController::class, 'fetchNotifications'])->name('fetch');
    Route::get('/count', [NotificationController::class, 'countNotification'])->name('count');
    Route::post('/store', [NotificationController::class, 'store'])->name('store'); // Kapan notif di-store?
    Route::post('/markAsRead', [NotificationController::class, 'markAsRead'])->name('markAsRead');
});

// ===========================
// ⭐ Review
// ===========================
// Menggunakan rute individual untuk kejelasan, bisa juga resource dengan ->only()
// Pastikan ReviewController dan method-methodnya ada
Route::middleware('auth')->group(function () { // Review biasanya butuh auth
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit'); // {review} untuk model binding
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update'); // {review} untuk model binding
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy'); // {review} untuk model binding
});

// Hapus rute ini jika tidak digunakan atau sudah dicakup ReviewController
// Route::get('/review', [CarController::class, 'reviewPage'])->name('cars.review');

// 🔐 Auth
require __DIR__ . '/auth.php';