<?php

namespace App\Http\Controllers;

use App\Models\RentalReview;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentalReviewController extends Controller
{
    public function index()
    {
        $pendingBookings = DB::select("SELECT * FROM bookings WHERE status = 'selesai'");

        $reviews = \App\Models\RentalReview::where('rental_id', auth()->id())
            ->with(['customer', 'booking.vehicle'])
            ->latest()
            ->get();

        return view('rental.reviews.index', compact('pendingBookings', 'reviews'));
    }

    public function create(Booking $booking)
    {
        // Check if rental owns this booking's vehicle
        if ($booking->vehicle->rental_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        // Check if booking is completed
        if ($booking->status !== 'selesai') {
            return redirect()->back()->with('error', 'Can only review completed bookings');
        }

        // Check if review already exists
        if ($booking->rentalReview) {
            return redirect()->back()->with('error', 'Review already exists for this booking');
        }

        return view('rental.reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Prevent duplicate review for the same booking by this rental
        $alreadyReviewed = RentalReview::where('booking_id', $booking->id)
            ->where('rental_id', auth()->id())
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk booking ini.');
        }

        RentalReview::create([
            'rental_id'   => auth()->id(),
            'customer_id' => $booking->user_id,
            'booking_id'  => $booking->id,
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'] ?? null,
        ]);

        return redirect()->route('rental.dashboard')->with('success', 'Review berhasil dikirim!');
    }

    public function edit(RentalReview $review)
    {
        if ($review->rental_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        return view('rental.reviews.edit', compact('review'));
    }

    public function update(Request $request, RentalReview $review)
    {
        if ($review->rental_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('rental.reviews.index')
            ->with('success', 'Review updated successfully');
    }

    public function destroy(RentalReview $review)
    {
        if ($review->rental_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $review->delete();

        return redirect()->route('rental.reviews.index')
            ->with('success', 'Review deleted successfully');
    }
} 