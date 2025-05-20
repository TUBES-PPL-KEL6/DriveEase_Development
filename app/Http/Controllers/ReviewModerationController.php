<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewModerationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except('report');
    }

    /**
     * Display a listing of reported reviews.
     */
    public function index()
    {
        $reportedReviews = Review::reported()
            ->with(['user', 'vehicle'])
            ->latest('reported_at')
            ->paginate(10);

        return view('admin.reviews.reported', compact('reportedReviews'));
    }

    /**
     * Approve a review.
     */
    public function approve(Review $review)
    {
        $this->authorize('update', $review);

        $review->update([
            'is_approved' => true,
            'reported_at' => null,
            'report_reason' => null
        ]);

        return redirect()->back()->with('success', 'Review has been approved.');
    }

    /**
     * Remove a review.
     */
    public function remove(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();
        return redirect()->back()->with('success', 'Review has been removed.');
    }

    /**
     * Report a review.
     */
    public function report(Request $request, Review $review)
    {
        $this->authorize('report', $review);

        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $review->update([
            'reported_at' => now(),
            'report_reason' => $request->reason
        ]);

        return redirect()->back()->with('success', 'Review has been reported for moderation.');
    }
} 