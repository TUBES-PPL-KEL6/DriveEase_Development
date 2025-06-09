<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;
use App\Notifications\DocumentVerified;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get total users count
        $totalUsers = \App\Models\User::where('role', 'pelanggan')->count();

        // Get total rentals count
        $totalRentals = \App\Models\User::where('role', 'rental')->count();

        // Get total profit from all bookings
        $totalProfit = \App\Models\Booking::sum('total_price');

        // Get user registration data for all months of the current year
        $userRegistrations = collect(range(1, 12))->map(function ($month) {
            $count = \App\Models\User::where('role', 'pelanggan')
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

    // Menampilkan daftar pelanggan dengan dokumen pending
    public function listDocuments()
    {
        $users = User::where('role', 'pelanggan')
            ->where('document_status', 'pending')
            ->get();

        return view('admin.verify_documents', compact('users'));
    }

    // Proses verifikasi (setujui atau tolak dokumen)
    public function verifyDocument(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $user = User::findOrFail($id);
        $user->update(['document_status' => $request->status]);

        // Kirim notifikasi (opsional jika sudah dibuat)
        $user->notify(new \App\Notifications\DocumentVerified($request->status));

        return redirect()->back()->with('success', 'Status dokumen diperbarui.');
    }
}
