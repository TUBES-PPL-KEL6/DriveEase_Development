<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Ulasan</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="max-w-xl space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="rating" class="block font-medium mb-1">Rating:</label>
                <select name="rating" id="rating" class="border rounded w-full p-2" required>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="comment" class="block font-medium mb-1">Komentar:</label>
                <textarea name="comment" id="comment" rows="4" class="border rounded w-full p-2" required>{{ $review->comment }}</textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </form>
    </div>
</x-app-layout>
