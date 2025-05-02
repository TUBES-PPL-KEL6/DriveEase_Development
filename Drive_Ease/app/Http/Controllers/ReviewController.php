<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Cegah review ganda
        $existingReview = Review::where('user_id', auth()->id())
            ->where('car_id', $request->car_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Kamu sudah memberikan ulasan untuk mobil ini.');
        }

        // Simpan review baru
        Review::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim!');
    }

    public function edit(Review $review)
        {
            // pastikan hanya pemilik review yang bisa akses
            if ($review->user_id !== auth()->id()) {
                abort(403);
            }

            return view('reviews.edit', compact('review'));
        }

    public function update(Request $request, Review $review)
        {
            if ($review->user_id !== auth()->id()) {
                abort(403);
            }

            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string',
            ]);

            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return redirect()->route('cars.review')->with('success', 'Ulasan berhasil diperbarui!');
        }
        
        public function destroy(Review $review)
        {
            if ($review->user_id !== auth()->id()) {
                abort(403);
            }
        
            $review->delete();
        
            return redirect()->route('cars.review')->with('success', 'Ulasan berhasil dihapus.');
        }
        
}
