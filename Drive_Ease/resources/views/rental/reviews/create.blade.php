<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Booking Details</h3>
                        <div class="mt-2 text-sm text-gray-600">
                            <p><strong>Customer:</strong> {{ $booking->user->name }}</p>
                            <p><strong>Vehicle:</strong> {{ $booking->vehicle->name }}</p>
                            <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                        </div>
                    </div>

                    <form action="{{ route('rental.reviews.store', $booking) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                            <div class="mt-1 flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" class="hidden" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <label for="rating{{ $i }}" class="cursor-pointer">
                                        <svg class="w-8 h-8 {{ old('rating') >= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                            <textarea name="comment" id="comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('rental.reviews.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('input[name="rating"]').forEach(input => {
            input.addEventListener('change', function() {
                const rating = this.value;
                document.querySelectorAll('label svg').forEach((svg, index) => {
                    svg.classList.toggle('text-yellow-400', index < rating);
                    svg.classList.toggle('text-gray-300', index >= rating);
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 