<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{

    public function getAvailDriver(Request $request, Vehicle $vehicle)
    {
        try {
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            // Mengambil driver yang tidak memiliki job pada rentang tanggal yang dipilih
            $driver = Driver::where('rental_id', $vehicle->rental_id)
                ->whereDoesntHave('jobs', function ($query) use ($start_date, $end_date) {
                    $query->whereHas('booking', function ($q) {
                        $q->where('status', '!=', 'batal');
                    })
                        ->where(function ($q) use ($start_date, $end_date) {
                            $q->whereBetween('start_date', [$start_date, $end_date])
                                ->orWhereBetween('end_date', [$start_date, $end_date])
                                ->orWhere(function ($q) use ($start_date, $end_date) {
                                    $q->where('start_date', '<=', $start_date)
                                        ->where('end_date', '>=', $end_date);
                                });
                        });
                })->get();
            return response()->json($driver);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch available drivers',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::where('rental_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('rental.driver.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rental.driver.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $validated['rental_id'] = Auth::id();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('drivers', 'public');
            $validated['photo'] = Storage::url($path);
        }

        Driver::create($validated);

        return redirect()
            ->route('rental.drivers.index')
            ->with('success', 'Driver berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        $driver->load('jobs.booking.vehicle');
        return view('rental.driver.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        return view('rental.driver.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($driver->photo) {
                $oldPath = str_replace('/storage/', '', $driver->photo);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('photo')->store('drivers', 'public');
            $validated['photo'] = Storage::url($path);
        }

        $driver->update($validated);

        return redirect()
            ->route('rental.drivers.index')
            ->with('success', 'Data driver berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {

        // Delete photo if exists
        if ($driver->photo) {
            $path = str_replace('/storage/', '', $driver->photo);
            Storage::disk('public')->delete($path);
        }

        $driver->delete();

        return redirect()
            ->route('rental.drivers.index')
            ->with('success', 'Driver berhasil dihapus');
    }
}