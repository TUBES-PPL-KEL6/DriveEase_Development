<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class RentalDashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Statistik utama
    $totalBookings = $user->vehicles()
        ->withCount('bookings')
        ->get()
        ->sum('bookings_count');

    $totalRevenue = $user->vehicles()
        ->with('bookings')
        ->get()
        ->flatMap->bookings
        ->sum('total_price');

    $mostRentedVehicles = $user->vehicles()
        ->withCount('bookings')
        ->orderByDesc('bookings_count')
        ->take(5)
        ->get();

    // Semua booking selesai untuk rental ini
    $completedBookings = \App\Models\Booking::where('status', 'selesai')
        ->whereHas('vehicle', function ($q) use ($user) {
            $q->where('rental_id', $user->id);
        })
        ->with(['user', 'vehicle', 'rentalReview'])
        ->get();

    // Semua review untuk kendaraan rental ini
    $vehicleReviews = \App\Models\Review::whereHas('vehicle', function ($q) use ($user) {
            $q->where('rental_id', $user->id);
        })
        ->with(['user', 'vehicle'])
        ->latest()
        ->get();

    // Rata-rata rating tiap kendaraan
    $vehicleRatings = \App\Models\Vehicle::where('rental_id', $user->id)
        ->withCount(['reviews as total_reviews'])
        ->withAvg('reviews', 'rating')
        ->get();

    // Grafik pendapatan bulanan
    $monthlyRevenue = \App\Models\Booking::whereHas('vehicle', function($q) use ($user) {
            $q->where('rental_id', $user->id);
        })
        ->where('status', 'selesai')
        ->selectRaw('MONTH(start_date) as month, SUM(total_price) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $labels = [];
    $data = [];
    foreach (range(1, 12) as $m) {
        $labels[] = date('M', mktime(0, 0, 0, $m, 1));
        $found = $monthlyRevenue->firstWhere('month', $m);
        $data[] = $found ? $found->total : 0;
    }

    // Dummy grafik hanya untuk rental1
    if ($user->name === 'rental1') {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $data = [1200000, 900000, 1500000, 2000000, 1700000, 0, 0, 0, 0, 0, 0, 0];
    } else {
        // Data asli atau kosong untuk user lain
        $labels = [];
        $data = [];
    }

    return view('dashboard.rental', compact(
        'totalBookings',
        'totalRevenue',
        'mostRentedVehicles',
        'completedBookings',
        'vehicleReviews',
        'vehicleRatings',
        'labels',
        'data'
    ));
}

    public function history()
    {
        $user = auth()->user();
        $bookings = \App\Models\Booking::whereHas('vehicle', function ($q) use ($user) {
            $q->where('rental_id', $user->id);
        })
            ->with(['vehicle', 'user'])
            ->latest()
            ->get();

        return view('rental.history', compact('bookings'));
    }
}