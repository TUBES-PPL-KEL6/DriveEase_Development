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
            ->get()
            ->flatMap->bookings
            ->sum('total_price');

        $mostRentedVehicles = $user->vehicles()
            ->withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        return view('dashboard.rental', compact('totalBookings', 'totalRevenue', 'mostRentedVehicles'));
    }
}
