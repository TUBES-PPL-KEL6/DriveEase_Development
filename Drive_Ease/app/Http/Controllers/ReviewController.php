<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $existingReview = Review::where('user_id', auth()->id())
            ->where('vehicle_id', $request->vehicle_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Kamu sudah memberikan ulasan.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $request->vehicle_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('vehicles.show', $request->vehicle_id)
            ->with('success', 'Ulasan berhasil dikirim!');
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('vehicles.show', $review->vehicle_id)
            ->with('success', 'Ulasan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id != auth()->id()) {
            abort(403);
        }

        $vehicleId = $review->vehicle_id;
        $review->delete();

        return redirect()->route('vehicles.show', $vehicleId)
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}
