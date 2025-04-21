<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModReview;
use Illuminate\Support\Facades\Auth;

class contReviewController extends Controller
{
    public function index()
    {
        $reviews = ModReview::with(['user', 'vehicle'])->latest()->get();
        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        ModReview::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $request->vehicle_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Ulasan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $review = ModReview::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = ModReview::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Ulasan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $review = ModReview::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Ulasan berhasil dihapus');
    }
}
