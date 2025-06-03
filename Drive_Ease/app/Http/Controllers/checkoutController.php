<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class checkoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cars = Car::all();
        return view('payment.checkout', compact('cars'));
    }

    public function returnToDashboard()
    {
        return redirect()->route('user.dashboard');
    }
}
