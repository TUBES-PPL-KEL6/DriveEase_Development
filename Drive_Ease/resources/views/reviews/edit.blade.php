<x-app-layout>
    <div class="max-w-xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Edit Ulasan</h1>

        <form method="POST" action="{{ route('reviews.update', $review->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Rating (1–5)</label>
                <input type="number" name="rating" min="1" max="5" value="{{ $review->rating }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-medium">Ulasan</label>
                <textarea name="review" rows="4" class="w-full border rounded p-2" required>{{ $review->review }}</textarea>
            </div>

            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
