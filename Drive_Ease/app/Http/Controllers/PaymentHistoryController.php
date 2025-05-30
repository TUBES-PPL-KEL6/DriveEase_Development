<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\PaymentHistory;
// use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    public function create()
    {
        return view('payment.checkout');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'car' => 'required|max:255',
            'price' => 'required|numeric',
        ]);

        // Yang benar mana payment history, rents atau bookings??
        // PaymentHistory::create($request->only(['username', 'car', 'price']));

        // store booking data
        $booking = Booking::create([
            'customer_id' => Auth::user()->id,
            'car_id' => $request->car,
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(7),
            'total_price' => $request->price,
            'status' => 'menunggu konfirmasi',
            'side_note' => 'Sewa berhasil dibuat pada ' . now()->format('d M Y, H:i'),
        ]);

        // push notification to rental owner
        $notification = Notification::create([
            'user_id' => $booking->car->owner->id,
            'title' => 'Penyewaan Baru',
            'message' => 'Penyewaan baru telah dibuat oleh ' . $booking->customer->username . ' untuk ' . $booking->car->name . ' sebesar ' . $booking->total_price . ' menunggu konfirmasi',
            'type' => 'rent',
            'status' => 'unread',
            'link' => '/rental/bookings/' . $booking->id,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Transaksi Berhasil');
    }

    public function index()
    {
        $paymentHistories = PaymentHistory::all();

        return view('payment.index', compact('paymentHistories'));
    }
}
