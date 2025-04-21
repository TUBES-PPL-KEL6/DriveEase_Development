<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
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

        return redirect()->route('user.dashboard')->with('success', 'Transaksi Berhasil');

    }

    public function index()
    {
        $paymentHistories = PaymentHistory::all();

        return view('payment.index', compact('paymentHistories'));
    }
}
