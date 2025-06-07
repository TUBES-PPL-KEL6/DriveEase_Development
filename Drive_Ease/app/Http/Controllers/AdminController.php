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
        // Ambil semua user
        $users = User::all();

        // Hitung user aktif per role
            $totalUsers = \App\Models\User::where('role', 'pelanggan')->count();
            $totalRentals = \App\Models\User::where('role', 'rental')->count();

        // Ambil data transaksi per bulan tahun ini
        $monthlyBookings = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $transactions = Booking::with(['user', 'vehicle'])->latest()->get();

        // Siapkan data chart
        $chartLabels = [];
        $chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $label = Carbon::create()->month($i)->format('M');
            $chartLabels[] = $label;

            $data = $monthlyBookings->firstWhere('month', $i);
            $chartData[] = $data ? $data->total : 0;
        }

        return view('dashboard.admin', compact(
            'users',
            'activeUsers',
            'activeRentals',
            'chartLabels',
            'chartData',
            'transactions'
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