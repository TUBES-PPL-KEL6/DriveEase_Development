<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get total users count
        $totalUsers = User::where('role', 'pelanggan')->count();
        
        // Get total rentals count
        $totalRentals = User::where('role', 'rental')->count();
        
        // Get total profit from all bookings
        $totalProfit = Booking::sum('total_price');
        
        // Get user registration data for all months of the current year
        $userRegistrations = collect(range(1, 12))->map(function ($month) {
            $count = User::where('role', 'pelanggan')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->count();
                
            return [
                'month' => date('F', mktime(0, 0, 0, $month, 1)),
                'count' => $count
            ];
        });

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalRentals',
            'totalProfit',
            'userRegistrations'
        ));
    }
} 