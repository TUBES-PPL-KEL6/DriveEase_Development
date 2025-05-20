<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Review Mobil</h2>
    </x-slot>

    <div class="p-4">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @foreach ($cars as $car)
            <div class="bg-white rounded shadow p-4 mb-8">
                {{-- Info Mobil --}}
                <h3 class="text-2xl font-bold">{{ $car->name }}</h3>

                @if ($car->average_rating)
                    <div class="flex items-center gap-2 mt-1">
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= round($car->average_rating) ? 'orange' : 'none' }}" viewBox="0 0 24 24" stroke="orange" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.234 6.869h7.215c.969 0 1.371 1.24.588 1.81l-5.838 4.245 2.234 6.869c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.838 4.245c-.783.57-1.838-.197-1.538-1.118l2.234-6.869-5.838-4.245c-.783-.57-.38-1.81.588-1.81h7.215l2.234-6.869z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600">({{ $car->average_rating }})</span>
                    </div>
                @else
                    <p class="text-gray-400 italic mt-1">Belum ada rating</p>
                @endif

                <div class="text-gray-600 mb-4">
                    <p>Brand: <strong>{{ $car->brand }}</strong></p>
                    <p>Model: <strong>{{ $car->model }}</strong></p>
                    <p>Warna: <strong>{{ $car->color }}</strong></p>
                    <p>Tahun: <strong>{{ $car->year }}</strong></p>
                </div>

                @php
                    $userReview = $car->reviews->firstWhere('user_id', $userId);
                @endphp

                @if ($userReview)
                    <p class="text-green-600 font-medium mt-2 mb-4">✅ Kamu sudah memberikan ulasan untuk mobil ini.</p>
                @else
                    {{-- Form Review --}}
                    <div class="border-t pt-4 mt-4">
                        <h4 class="text-lg font-semibold mb-2">Beri Ulasan:</h4>

                        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">

                            <div>
                                <label for="rating" class="block font-medium mb-1">Rating:</label>
                                <select name="rating" id="rating" class="border rounded w-full p-2" required>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label for="comment" class="block font-medium mb-1">Komentar:</label>
                                <textarea name="comment" id="comment" rows="3" class="border rounded w-full p-2" placeholder="Tulis ulasanmu..." required></textarea>
                            </div>

                            <div>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Kirim Ulasan
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- List Review --}}
                @if ($car->reviews->count())
                    <div class="border-t mt-6 pt-4">
                        <h4 class="text-lg font-semibold mb-2">Ulasan Pengguna:</h4>
                        @foreach ($car->reviews as $review)
                            <div class="border p-3 mb-2 rounded bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold">{{ $review->user->name }}</span>
                                        <p class="text-gray-700 mt-1">{{ $review->comment }}</p>
                                    </div>

                                    <div class="flex flex-col items-end gap-1">
                                        <span class="text-yellow-500 text-sm">{{ $review->rating }} ⭐</span>

                                        @if ($review->user_id === $userId)
                                            <div class="flex gap-2 text-sm">
                                                <a href="{{ route('reviews.edit', $review->id) }}"
                                                class="text-blue-600 hover:underline">Edit</a>

                                                <form action="{{ route('reviews.destroy', $review->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 mt-4">Belum ada ulasan untuk mobil ini.</p>
                @endif

            </div>
        @endforeach
    </div>
</x-app-layout>
