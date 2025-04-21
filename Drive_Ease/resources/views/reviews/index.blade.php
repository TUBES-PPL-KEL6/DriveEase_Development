<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Daftar Ulasan</h1>

        <a href="{{ route('reviews.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Ulasan</a>

        @foreach ($reviews as $review)
            <div class="bg-white shadow p-4 rounded mb-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Rating: {{ $review->rating }}/5</h2>
                    @if ($review->user_id === Auth::id())
                        <div class="space-x-2">
                            <a href="{{ route('reviews.edit', $review->id) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500" onclick="return confirm('Yakin hapus ulasan?')">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>
                <p class="text-gray-600 mt-2">{{ $review->review }}</p>
                <p class="text-sm text-gray-400 mt-1">Oleh: {{ $review->user->name }} | Mobil ID: {{ $review->vehicle_id }}</p>
            </div>
        @endforeach
    </div>
</x-app-layout>
