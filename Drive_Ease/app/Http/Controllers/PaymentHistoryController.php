<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PaymentHistory;
use App\Models\Rent;
use Illuminate\Http\Request;

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

        PaymentHistory::create($request->only(['username', 'car', 'price']));

        // store rent data
        $rent = Rent::create([
            'customer_id' => auth()->user()->id,
            'car_id' => $request->car,
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(7),
            'total_price' => $request->price,
            'status' => 'menunggu',
            'side_note' => 'Sewa berhasil dibuat pada ' . now()->format('d M Y, H:i'),
        ]);

        // push notification to rental owner
        $notification = Notification::create([
            'user_id' => $rent->car->owner->id,
            'title' => 'Penyewaan Baru',
            'message' => 'Penyewaan baru telah dibuat oleh ' . $rent->customer->username . ' untuk ' . $rent->car->name . ' sebesar ' . $rent->total_price . ' menunggu konfirmasi',
            'type' => 'rent',
            'status' => 'unread',
            'link' => '/rental/rents/' . $rent->id,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Transaksi Berhasil');
    }

    public function index()
    {
        $paymentHistories = PaymentHistory::all();

        return view('payment.index', compact('paymentHistories'));
    }
}
