<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Booking;
use Illuminate\Http\Request;

class RentalBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::whereHas('vehicle', function ($query) {
            $query->where('rental_id', auth()->user()->id);
        })->get();
        return view('rental.booking.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::find($id);
        return view('rental.booking.show', compact('booking'));
    }

    public function confirmBooking(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);
            $booking->status = 'konfirmasi';
            if ($request->side_note) {
                $booking->side_note = $request->side_note;
            }
            $booking->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengkonfirmasi sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $booking->user->id,
                'title' => 'Penyewaan Dikonfirmasi',
                'message' => 'Penyewaan ' . $booking->vehicle->name . ' Anda telah dikonfirmasi oleh pemilik rental. ' . $booking->side_note,
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/user/my-bookings/' . $booking->id,
            ]);
            return redirect()->back()->with('success', 'Sewa berhasil dikonfirmasi');
        }
    }

    public function rejectBooking(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);
            $booking->status = 'batal';
            if ($request->side_note) {
                $booking->side_note = $request->side_note;
            }
            $booking->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $booking->user->id,
                'title' => 'Penyewaan Dibatalkan',
                'message' => 'Penyewaan ' . $booking->vehicle->name . ' Anda telah dibatalkan oleh pemilik rental. ' . $booking->side_note,
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/user/my-bookings/' . $booking->id,
            ]);

            return redirect()->back()->with('success', 'Sewa berhasil dibatalkan');
        }
    }
}
