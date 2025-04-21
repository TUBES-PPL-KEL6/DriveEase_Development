<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class checkoutController extends Controller
{
    public function checkout(Request $request)
    {
        return view('payment.checkout');
        return redirect()->route('user.dashboard');
    }

    public function returnToDashboard()
    {
        return redirect()->route('user.dashboard');
    }

}
