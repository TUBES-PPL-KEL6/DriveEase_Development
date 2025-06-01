<?php

namespace App\Http\Controllers\Rental;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Excel;
use PDF;

class BookingController extends Controller
{
    public function history(Request $request)
    {
        $user = auth()->user();
        $bookings = \App\Models\Booking::whereHas('vehicle', function ($q) use ($user) {
                $q->where('rental_id', $user->id);
            })
            ->with(['vehicle', 'user'])
            ->latest()
            ->get();

        return view('rental.history', compact('bookings'));
    }

    public function export(Request $request)
    {
        $query = Booking::whereHas('vehicle', function ($q) {
            $q->where('user_id', auth()->id());
        })->with(['vehicle', 'user']);

        // Apply the same filters as in history method
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }
        if ($request->filled('min_price')) {
            $query->where('total_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('total_price', '<=', $request->max_price);
        }

        $bookings = $query->get();

        $format = $request->format ?? 'excel';
        $filename = 'bookings-' . now()->format('Y-m-d');

        switch ($format) {
            case 'excel':
                return Excel::download(new BookingsExport($bookings), $filename . '.xlsx');
            case 'csv':
                return Excel::download(new BookingsExport($bookings), $filename . '.csv');
            case 'pdf':
                $pdf = PDF::loadView('rental.bookings.export-pdf', compact('bookings'));
                return $pdf->download($filename . '.pdf');
            default:
                return back()->with('error', 'Invalid export format');
        }
    }
} 