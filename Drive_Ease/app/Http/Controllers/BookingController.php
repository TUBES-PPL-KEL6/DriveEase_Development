<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, Vehicle $vehicle)
    {

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'driver_id' => 'nullable',
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $vehicle->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        // Jika ada driver yang dipilih, maka update driver_id
        if ($request->driver_id) {
            $booking->driver_id = $request->driver_id;
            $booking->save();
        }

        // Mencatat jadwal kerja driver
        if ($request->driver_id) {
            $driver = Driver::findOrFail($request->driver_id);
            $driver->jobs()->create([
                'driver_id' => $request->driver_id,
                'booking_id' => $booking->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
        }

        // push notification to vehicle owner
        $notification = Notification::create([
            'user_id' => $vehicle->rental_id,
            'title' => 'Pemesanan Baru',
            'message' => 'Pemesanan baru untuk ' . $vehicle->name,
            'type' => 'rent',
            'status' => 'unread',
            'link' => '/rental/rents/' . $booking->id,
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

        // push notification to customer
        $notification = Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Pemesanan Disetujui',
            'message' => 'Pemesanan ' . $booking->vehicle->name . ' Anda telah disetujui.',
            'type' => 'rent',
            'status' => 'unread',
            'link' => '/user/my-bookings',
        ]);

        return redirect()->route('admin.payment.index')->with('success', 'Booking approved.');
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
