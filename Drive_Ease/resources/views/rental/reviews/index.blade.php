<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehicle Reviews Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900">Total Vehicles</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_vehicles'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900">Total Reviews</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_reviews'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900">Average Rating</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ number_format($stats['average_rating'], 1) }}/5</p>
                    </div>
                </div>
            </div>

            <!-- Vehicles List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Vehicles</h3>
                    @if($vehicles->isEmpty())
                        <p class="text-center text-gray-500">No vehicles found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Reviews</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average Rating</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($vehicles as $vehicle)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->reviews->count() }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ number_format($vehicle->reviews->avg('rating'), 1) }}/5
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('rental.reviews.show', $vehicle) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    View Reviews
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Rental Service Reviews Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Your Rental Service Reviews</h3>
                    @php
                        $rentalReviews = \App\Models\Review::where('rental_id', auth()->id())->approved()->latest()->take(5)->get();
                        $rentalAvg = \App\Models\Review::where('rental_id', auth()->id())->approved()->avg('rating');
                        $rentalCount = \App\Models\Review::where('rental_id', auth()->id())->approved()->count();
                    @endphp
                    <div class="mb-2">
                        <strong>Average Rating:</strong> {{ number_format($rentalAvg, 1) }}/5
                        <span class="ml-4"><strong>Total Reviews:</strong> {{ $rentalCount }}</span>
                    </div>
                    @if($rentalReviews->isEmpty())
                        <p class="text-gray-500">No reviews for your rental service yet.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach($rentalReviews as $review)
                                <li class="py-2">
                                    <span class="font-semibold">{{ $review->user->name }}</span>:
                                    <span class="text-yellow-500">{{ $review->rating }}★</span>
                                    <span class="ml-2 text-gray-700">{{ $review->comment }}</span>
                                    <span class="ml-2 text-xs text-gray-400">({{ $review->created_at->format('d M Y') }})</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 