<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reviews for') }} {{ $vehicle->name }}
            </h2>
            <a href="{{ route('rental.reviews.index') }}" class="text-indigo-600 hover:text-indigo-900">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Vehicle Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Total Reviews</h3>
                            <p class="text-3xl font-bold text-indigo-600">{{ $reviews->total() }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Average Rating</h3>
                            <p class="text-3xl font-bold text-indigo-600">{{ number_format($reviews->avg('rating'), 1) }}/5</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Reported Reviews</h3>
                            <p class="text-3xl font-bold text-indigo-600">{{ $reviews->where('is_reported', true)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($reviews->isEmpty())
                        <p class="text-center text-gray-500">No reviews found for this vehicle.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($reviews as $review)
                                <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                             fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="ml-2 text-sm text-gray-500">
                                                    {{ $review->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                            <p class="mt-2 text-gray-700">{{ $review->comment }}</p>
                                            <p class="mt-1 text-sm text-gray-500">
                                                By {{ $review->user->name }}
                                            </p>
                                        </div>
                                        @if($review->isReported())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Reported
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 