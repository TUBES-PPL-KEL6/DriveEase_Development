<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total user pelanggan
        $totalUsers = User::where('role', 'pelanggan')->count();

        // Total rental
        $totalRentals = User::where('role', 'rental')->count();

        // Total profit dari semua booking
        $totalProfit = Booking::sum('total_price');

        // Data registrasi user pelanggan per bulan tahun ini
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

    // Jika nanti ingin mendukung edit user via AJAX/modal
    public function getUserData(User $user)
    {
        return response()->json($user);
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|in:admin,rental,pelanggan',
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return response()->json(['success' => true, 'message' => 'User updated successfully']);
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }
}