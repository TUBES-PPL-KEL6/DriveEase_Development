<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class RentalVehicleController extends Controller
{
    public function index()
    {
        $vehicles = auth()->user()->vehicles()->paginate(10);
        return view('rental.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('rental.vehicles.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'location' => 'required|string',
        'category' => 'required|in:SUV,MPV,Sedan,Hatchback',
        'description' => 'nullable|string',
        'price_per_day' => 'required|integer|min:0',
        'available' => 'required|boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Ambil hanya field yang diperbolehkan
    $data = $request->only([
        'name',
        'location',
        'category',
        'description',
        'price_per_day',
        'available',
    ]);

    if ($request->hasFile('image')) {
        $data['image_path'] = $request->file('image')->store('vehicles', 'public');
    }

    // Simpan data dengan relasi ke rental yang sedang login
    auth()->user()->vehicles()->create($data);

    return redirect()->route('rental.vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan!');
}

public function edit($id)
{
    $vehicle = auth()->user()->vehicles()->findOrFail($id);
    return view('rental.vehicles.edit', compact('vehicle'));
}

public function update(Request $request, $id)
{
    $vehicle = auth()->user()->vehicles()->findOrFail($id);

    $request->validate([
        'name' => 'required|string',
        'location' => 'required|string',
        'category' => 'required|in:SUV,MPV,Sedan,Hatchback',
        'description' => 'nullable|string',
        'price_per_day' => 'required|integer|min:0',
        'available' => 'required|boolean',
    ]);

    $vehicle->update($request->only([
        'name', 'location', 'category', 'description', 'price_per_day', 'available'
    ]));

    return redirect()->route('rental.vehicles.index')->with('success', 'Kendaraan berhasil diperbarui!');
}

public function destroy($id)
{
    $vehicle = auth()->user()->vehicles()->findOrFail($id);
    $vehicle->delete();

    return redirect()->route('rental.vehicles.index')->with('success', 'Kendaraan berhasil dihapus!');
}


}

