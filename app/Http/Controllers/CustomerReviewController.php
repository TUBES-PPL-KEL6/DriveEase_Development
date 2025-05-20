<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    // Show reviews received by a user
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        $reviews = CustomerReview::where('reviewed_id', $userId)->with('reviewer')->latest()->paginate(10);
        return view('customer_reviews.index', compact('user', 'reviews'));
    }

    // Store a new customer review
    public function store(Request $request, $rentId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $rent = Rent::findOrFail($rentId);
        $reviewedId = $rent->customer_id === Auth::id() ? $rent->rental_id : $rent->customer_id;

        // Prevent duplicate reviews for the same rent and user
        $exists = CustomerReview::where('reviewer_id', Auth::id())
            ->where('reviewed_id', $reviewedId)
            ->where('rent_id', $rentId)
            ->exists();
        if ($exists) {
            return back()->withErrors(['You have already reviewed this user for this rental.']);
        }

        CustomerReview::create([
            'reviewer_id' => Auth::id(),
            'reviewed_id' => $reviewedId,
            'rent_id' => $rentId,
            'rating' => $request->rating,
            'comment' => strip_tags($request->comment),
        ]);

        return back()->with('success', 'Review submitted!');
    }
} 