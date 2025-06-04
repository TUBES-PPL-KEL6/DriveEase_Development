<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RentalDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalBookings = $user->vehicles()
            ->withCount('bookings')
            ->get()
            ->sum('bookings_count');

        $totalRevenue = $user->vehicles()
            ->with('bookings')
            ->get() // gunakan get() untuk ambil koleksi kendaraan
            ->flatMap->bookings // gabungkan semua bookings
            ->sum('total_price'); // jumlahkan total_price dari semua booking

        $mostRentedVehicles = $user->vehicles()
            ->withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        // Show all completed bookings for this rental, not just those not yet reviewed
        $completedBookings = \App\Models\Booking::where('status', 'selesai')
            ->whereHas('vehicle', function ($q) use ($user) {
                $q->where('rental_id', $user->id);
            })
            ->with(['user', 'vehicle', 'rentalReview'])
            ->get();

        // Get all reviews for rental's vehicles
        $vehicleReviews = \App\Models\Review::whereHas('vehicle', function ($q) use ($user) {
            $q->where('rental_id', $user->id);
        })
            ->with(['user', 'vehicle'])
            ->latest()
            ->get();

        // Calculate average ratings for each vehicle
        $vehicleRatings = \App\Models\Vehicle::where('rental_id', $user->id)
            ->withCount(['reviews as total_reviews'])
            ->withAvg('reviews', 'rating')
            ->get();

        return view('dashboard.rental', compact(
            'totalBookings',
            'totalRevenue',
            'mostRentedVehicles',
            'completedBookings',
            'vehicleReviews',
            'vehicleRatings'
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
