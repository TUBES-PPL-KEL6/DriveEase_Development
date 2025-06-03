<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Booking;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Config;


class CheckoutController extends Controller
{

    public function index(Request $request)
    {
        $bookings = Booking::where('user_id', auth()->id())->with('vehicle')->latest()->get();

        $vehicles = Vehicle::query()
            ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->price_min, fn($q) => $q->where('price_per_day', '>=', $request->price_min))
            ->when($request->price_max, fn($q) => $q->where('price_per_day', '<=', $request->price_max))
            ->where('available', true)
            ->get();
        return view('payment.checkout', [
            'bookings' => $bookings,
            'vehicles' => $vehicles,
        ]);
    }

    public function show($id)
    {
        $payment = Booking::findOrFail($id);
        return view('payment.payment', compact('payment'));
    }

    public function payment($id)
    {
        $payment = Booking::findOrFail($id);

        if ($payment->status === 'paid') {
            return redirect()->route('home')->with('success', 'Pembayaran sudah dilakukan.');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat order ID dan simpan
        $orderId = 'TRX-' . uniqid();
        $payment->order_id = $orderId;
        $payment->save();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $payment->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'callbacks' => [
                'finish' => route('payment.finish')
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment.payment', [
            'payment' => $payment,
            'snapToken' => $snapToken,
        ]);
    }



    public function Dashboard(Request $request)
    {
        // logic buat dashboard user (kalau ada)
        $bookings = Booking::where('user_id', auth()->id())
            ->with('vehicle')
            ->latest()
            ->get();

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

    public function finish(Request $request)
    {
        $orderId = $request->get('order_id'); // ini dikirim Midtrans
        $this->updateStatus($orderId);

        return redirect()->route('user.dashboard.user')->with('success', 'Pembayaran sudah dilakukan.');
    }


    private function updateStatus($orderId)
    {
        $payment = Booking::where('order_id', $orderId)->first();

        if ($payment) {
            $payment->status = 'menunggu konfirmasi';
            $payment->save();
        }
    }
}