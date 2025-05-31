<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransactionController extends Controller
{
    public function index()
    {
        // Get all rentals with their total profits
        $rentals = User::where('role', 'rental')
            ->withCount(['vehicles as total_vehicles'])
            ->with(['vehicles.bookings' => function($query) {
                $query->select('vehicle_id', 'total_price');
            }])
            ->get()
            ->map(function($rental) {
                return [
                    'id' => $rental->id,
                    'name' => $rental->name,
                    'email' => $rental->email,
                    'total_vehicles' => $rental->total_vehicles,
                    'total_profit' => $rental->vehicles->sum(function($vehicle) {
                        return $vehicle->bookings->sum('total_price');
                    })
                ];
            });

        return view('admin.transactions.index', compact('rentals'));
    }

    public function show(User $rental)
    {
        // Get all transactions for this rental
        $transactions = Booking::whereHas('vehicle', function($query) use ($rental) {
            $query->where('rental_id', $rental->id);
        })
        ->with(['user', 'vehicle'])
        ->latest()
        ->paginate(10);

        // Calculate total profit
        $total_profit = $transactions->sum('total_price');

        // Add total profit to rental object
        $rental->total_profit = $total_profit;
        $rental->total_vehicles = $rental->vehicles()->count();

        return view('admin.transactions.show', compact('rental', 'transactions'));
    }
} 