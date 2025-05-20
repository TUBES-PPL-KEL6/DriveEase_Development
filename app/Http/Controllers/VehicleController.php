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

    $vehicles = Vehicle::query()
        ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
        ->when($request->category, fn($q) => $q->where('category', $request->category))
        ->when($request->price_min, fn($q) => $q->where('price_per_day', '>=', $request->price_min))
        ->when($request->price_max, fn($q) => $q->where('price_per_day', '<=', $request->price_max))
        ->where('available', true)
        ->get();

    return view('vehicles.index', compact('vehicles'));
}

    public function show($id)
{
    $vehicle = Vehicle::with(['reviews.user'])->findOrFail($id);

    $userId = auth()->id();

    return view('vehicles.show', compact('vehicle', 'userId'));
}

    // public function show($id)
    // {
    //     $vehicle = Vehicle::with('reviews.user')->findOrFail($id);
    //     return view('vehicles.show', compact('vehicle'));
    // }
}
