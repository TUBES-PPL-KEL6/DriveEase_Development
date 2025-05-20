<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class RentalReviewController extends Controller
{
    /**
     * Display the rental owner's dashboard with vehicle ratings.
     */
    public function index()
    {
        $vehicles = auth()->user()->vehicles()->with(['reviews' => function ($query) {
            $query->approved();
        }])->get();

        $stats = [
            'total_vehicles' => $vehicles->count(),
            'total_reviews' => $vehicles->sum(function ($vehicle) {
                return $vehicle->reviews->count();
            }),
            'average_rating' => $vehicles->avg(function ($vehicle) {
                return $vehicle->reviews->avg('rating');
            }),
        ];

        return view('rental.reviews.index', compact('vehicles', 'stats'));
    }

    /**
     * Display detailed reviews for a specific vehicle.
     */
    public function show(Vehicle $vehicle)
    {
        // Ensure the vehicle belongs to the rental owner
        if ($vehicle->rental_id !== auth()->id()) {
            abort(403);
        }

        $reviews = $vehicle->reviews()
            ->with('user')
            ->approved()
            ->latest()
            ->paginate(10);

        $stats = [
            'total_reviews' => $reviews->total(),
            'average_rating' => $vehicle->reviews()->approved()->avg('rating'),
            'rating_distribution' => $this->getRatingDistribution($vehicle),
        ];

        return view('rental.reviews.show', compact('vehicle', 'reviews', 'stats'));
    }

    /**
     * Get the distribution of ratings for a vehicle.
     */
    private function getRatingDistribution(Vehicle $vehicle)
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $vehicle->reviews()
                ->approved()
                ->where('rating', $i)
                ->count();
        }
        return $distribution;
    }
} 