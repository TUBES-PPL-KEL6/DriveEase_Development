<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;

class RentalDriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::where('rental_id', Auth::id())->get();
        return view('rental.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('rental.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        Driver::create([
            'rental_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        return redirect()->route('rental.drivers.index')->with('success', 'Driver berhasil ditambahkan');
    }

    public function scheduleForm(Driver $driver)
    {
        if ($driver->rental_id != Auth::id()) abort(403);
        return view('rental.drivers.schedule', compact('driver'));
    }

    public function schedule(Request $request, Driver $driver)
    {
        if ($driver->rental_id != Auth::id()) abort(403);

        $driver->update([
            'schedule' => $request->schedule, // ex: ['monday' => '08:00-17:00', ...]
        ]);

        return redirect()->route('rental.drivers.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroyInactive()
    {
        Driver::where('rental_id', Auth::id())
            ->where('is_active', false)
            ->delete();

        return redirect()->route('rental.drivers.index')->with('success', 'Driver tidak aktif berhasil dihapus');
    }
}
