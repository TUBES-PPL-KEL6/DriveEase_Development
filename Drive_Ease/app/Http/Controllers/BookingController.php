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

    public function myBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())->with('vehicle')->latest()->get();
        return view('bookings.mine', compact('bookings'));
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
}

