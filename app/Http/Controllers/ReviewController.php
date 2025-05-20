<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Review::class, 'review');
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request, $vehicleId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        $vehicle = Vehicle::findOrFail($vehicleId);
        $rentalId = $vehicle->rental_id;

        // Ensure user has rented this vehicle and hasn't already reviewed this rental service for this vehicle
        // $hasRented = $vehicle->bookings()->where('user_id', Auth::id())->exists();
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('vehicle_id', $vehicleId)
            ->where('rental_id', $rentalId)
            ->exists();

        // if (!$hasRented) return back()->withErrors(['You can only review rental services you have rented from.']);
        if ($alreadyReviewed) return back()->withErrors(['You have already reviewed this rental service for this vehicle.']);

        Review::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $vehicleId,
            'rental_id' => $rentalId,
            'rating' => $request->rating,
            'comment' => strip_tags($request->comment),
        ]);
        return back()->with('success', 'Review submitted!');
    }

    /**
     * Show the form for editing the review.
     */
    public function edit(Review $review)
    {
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review.
     */
    public function update(ReviewRequest $request, Review $review)
    {
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('vehicles.show', $review->vehicle_id)
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    public function showVehicleReviews($vehicleId)
    {
        $vehicle = Vehicle::with('reviews.user')->findOrFail($vehicleId);
        return view('reviews.vehicle', compact('vehicle'));
    }

    public function ownerDashboard()
    {
        $vehicles = Auth::user()->vehicles()->with('reviews')->get();
        return view('reviews.owner_dashboard', compact('vehicles'));
    }
}
