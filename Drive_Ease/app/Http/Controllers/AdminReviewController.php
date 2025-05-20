<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'vehicle'])
            ->when($request->input('reported'), fn($q) => $q->whereNotNull('reported_at'))
            ->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review, Request $request)
    {
        $review->is_approved = false;
        $review->report_reason = $request->input('reason');
        $review->delete();
        // Log admin action
        if (class_exists(AuditLog::class)) {
            AuditLog::create([
                'admin_id' => auth()->id(),
                'action' => 'remove_review',
                'target_id' => $review->id,
                'description' => $request->input('reason'),
            ]);
        }
        return back()->with('success', 'Review removed.');
    }

    public function vehiclesReviews()
    {
        $vehicles = \App\Models\Vehicle::with(['rental', 'reviews.user'])->get();
        return view('admin.reviews.vehicles', compact('vehicles'));
    }
} 