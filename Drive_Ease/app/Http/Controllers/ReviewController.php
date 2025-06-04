<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Vehicle; // Pastikan model Vehicle di-import
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

        // Mengecek apakah user sudah memberikan ulasan untuk kendaraan ini
        $existingReview = Review::where('user_id', auth()->id())
            ->where('vehicle_id', $request->vehicle_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk kendaraan ini.');
        }

        // Menyimpan review baru
        $review = Review::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $request->vehicle_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update reviews_count pada kendaraan yang terkait
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $vehicle->reviews_count = $vehicle->reviews()->count();
        $vehicle->save();

        return redirect()->route('vehicles.show', $request->vehicle_id)
            ->with('success', 'Ulasan berhasil dikirim!');
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Memastikan user yang ingin mengedit adalah pemilik review
        if ($review->user_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki hak untuk mengedit ulasan ini.');
        }

        // Validasi form update
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // Mengupdate review
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update reviews_count pada kendaraan yang terkait
        $vehicle = Vehicle::findOrFail($review->vehicle_id);
        $vehicle->reviews_count = $vehicle->reviews()->count();
        $vehicle->save();

        return redirect()->route('vehicles.show', $review->vehicle_id)
            ->with('success', 'Ulasan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Memastikan user yang ingin menghapus adalah pemilik review
        if ($review->user_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki hak untuk menghapus ulasan ini.');
        }

        $vehicleId = $review->vehicle_id;
        $review->delete();

        // Update reviews_count pada kendaraan yang terkait setelah penghapusan
        $vehicle = Vehicle::findOrFail($vehicleId);
        $vehicle->reviews_count = $vehicle->reviews()->count();
        $vehicle->save();

        return redirect()->route('vehicles.show', $vehicleId)
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}
