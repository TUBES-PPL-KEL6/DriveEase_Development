<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'pelanggan') {
            abort(403, 'Akses hanya untuk pelanggan.');
        }

        // Query untuk mengambil kendaraan yang tersedia dengan filter
        $vehicles = Vehicle::query()
            ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->price_min, fn($q) => $q->where('price_per_day', '>=', $request->price_min))
            ->when($request->price_max, fn($q) => $q->where('price_per_day', '<=', $request->price_max))
            ->where('available', true)
            ->paginate(9);  // Menggunakan pagination untuk membatasi hasil

        return view('vehicles.index', compact('vehicles'));
    }

    public function show($id)
    {
        // Load data kendaraan dengan relasi reviews dan user pada ulasan
        $vehicle = Vehicle::with(['reviews.user'])->findOrFail($id);

        // Pastikan id user yang login di-pass untuk akses form review
        $userId = auth()->id();

        return view('vehicles.show', compact('vehicle', 'userId'));
    }
}
