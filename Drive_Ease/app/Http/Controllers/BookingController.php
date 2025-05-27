<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        Booking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $vehicle->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect()->route('user.bookings.mine')->with('success', 'Pemesanan berhasil dikirim!');
    }

    public function myBookings(Request $request)
    {
        $bookings = Booking::where('user_id', auth()->id())->with('vehicle')->latest()->get();
        
        $vehicles = Vehicle::query()
        ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
        ->when($request->category, fn($q) => $q->where('category', $request->category))
        ->when($request->price_min, fn($q) => $q->where('price_per_day', '>=', $request->price_min))
        ->when($request->price_max, fn($q) => $q->where('price_per_day', '<=', $request->price_max))
        ->where('available', true)
        ->get();
           return view('bookings.mine', [
        'bookings' => $bookings,
        'vehicles' => $vehicles,
    ]);
    }


    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
    
        // Cegah jika status sudah approved atau cancelled
        if (in_array($booking->status, ['approved', 'cancelled'])) {
            return redirect()->route('admin.payment.index')->with('error', 'Booking status already changed.');
        }
    
        // Ganti status menjadi approved
        $booking->status = 'approved';
        $booking->save();
    
        return redirect()->route('admin.payment.index')->with('success', 'Booking approved.');
    }
    
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
    
        // Cegah jika status sudah approved atau cancelled
        if (in_array($booking->status, ['approved', 'cancelled'])) {
            return redirect()->route('admin.payment.index')->with('error', 'Booking status sudah tidak bisa diubah.');
        }
    
        $booking->status = 'cancelled';
        $booking->save();
    
        return redirect()->route('admin.payment.index')->with('success', 'Booking cancelled.');
    }

public function Booking_Dashboard(Request $request)
{
    // Ambil bookings user yang login
    $bookings = Booking::where('user_id', auth()->id())
        ->with('vehicle')
        ->latest()
        ->get();

    // Ambil kendaraan yang tersedia dengan filter
    $vehicles = Vehicle::query()
        ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
        ->when($request->category, fn($q) => $q->where('category', $request->category))
        ->when($request->price_min, fn($q) => $q->where('price_per_day', '>=', $request->price_min))
        ->when($request->price_max, fn($q) => $q->where('price_per_day', '<=', $request->price_max))
        ->where('available', true)
        ->get();

    return view('dashboard.user', [
        'bookings' => $bookings,
        'vehicles' => $vehicles,
    ]);
}

}