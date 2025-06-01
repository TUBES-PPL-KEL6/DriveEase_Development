<?php

namespace App\Http\Controllers;

use App\Models\FlaggedReview;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlaggedReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'reason' => 'required|string|in:spam,inappropriate,fake,other',
            'details' => 'nullable|string|max:1000',
        ]);

        // Check if review belongs to rental's vehicle
        $review = Review::with('vehicle')->findOrFail($request->review_id);
        if ($review->vehicle->rental_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access');
        }

        // Check if already flagged
        $alreadyFlagged = FlaggedReview::where('review_id', $request->review_id)
            ->where('rental_id', Auth::id())
            ->exists();

        if ($alreadyFlagged) {
            return back()->with('error', 'Anda sudah melaporkan ulasan ini sebelumnya.');
        }

        // Create flag
        FlaggedReview::create([
            'review_id' => $request->review_id,
            'rental_id' => Auth::id(),
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        return back()->with('success', 'Ulasan berhasil dilaporkan. Tim moderasi akan meninjau laporan Anda.');
    }
} 