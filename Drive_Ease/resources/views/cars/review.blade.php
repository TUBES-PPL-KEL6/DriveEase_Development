<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Ulasan Kendaraan</h2> {{-- Sesuaikan ukuran font dan warna --}}
    </x-slot>

    <div class="py-6"> {{-- Tambahkan padding vertikal --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> {{-- Tambahkan wrapper max-w dan spasi antar elemen --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-700 border border-green-200 px-4 py-3 rounded-lg relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.03a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 border border-red-200 px-4 py-3 rounded-lg relative" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.03a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif

            @forelse ($cars as $car)
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200"> {{-- Card untuk setiap mobil --}}
                    {{-- Info Mobil --}}
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $car->name }}</h3>

                    @if ($car->average_rating)
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex text-yellow-500"> {{-- Warna bintang kuning --}}
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= round($car->average_rating) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.234 6.869h7.215c.969 0 1.371 1.24.588 1.81l-5.838 4.245 2.234 6.869c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.838 4.245c-.783.57-1.838-.197-1.538-1.118l2.234-6.869-5.838-4.245c-.783-.57-.38-1.81.588-1.81h7.215l2.234-6.869z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">({{ number_format($car->average_rating, 1) }}) dari {{ $car->reviews->count() }} ulasan</span> {{-- Format rata-rata rating --}}
                        </div>
                    @else
                        <p class="text-gray-500 italic mb-4">Belum ada rating.</p>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-gray-700 mb-6">
                        <p>Brand: <strong class="font-semibold">{{ $car->brand }}</strong></p>
                        <p>Model: <strong class="font-semibold">{{ $car->model }}</strong></p>
                        <p>Warna: <strong class="font-semibold">{{ $car->color }}</strong></p>
                        <p>Tahun: <strong class="font-semibold">{{ $car->year }}</strong></p>
                    </div>

                    @php
                        $userReview = $car->reviews->firstWhere('user_id', $userId);
                    @endphp

                    @if ($userReview)
                        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded-lg mb-6 flex items-center justify-between">
                            <p class="font-medium">✅ Kamu sudah memberikan ulasan untuk mobil ini.</p>
                            <a href="{{ route('reviews.edit', $userReview->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">Edit Ulasan Anda</a>
                        </div>
                    @else
                        {{-- Form Review --}}
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="text-xl font-semibold text-gray-800 mb-4">Beri Ulasan Anda:</h4>

                            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $car->id }}">

                                <div>
                                    <label for="rating-{{ $car->id }}" class="block text-gray-700 font-medium mb-1">Rating:</label>
                                    <select name="rating" id="rating-{{ $car->id }}" class="form-select border border-gray-300 rounded-lg w-full p-2.5 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label for="comment-{{ $car->id }}" class="block text-gray-700 font-medium mb-1">Komentar:</label>
                                    <textarea name="comment" id="comment-{{ $car->id }}" rows="4" class="form-textarea border border-gray-300 rounded-lg w-full p-2.5 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Tulis ulasanmu tentang mobil ini..." required></textarea>
                                </div>

                                <div>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300 shadow-md">
                                        Kirim Ulasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    {{-- List Review --}}
                    <div class="border-t border-gray-200 mt-8 pt-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Ulasan dari Pengguna Lain:</h4>
                        @forelse ($car->reviews->sortByDesc('created_at') as $review) {{-- Urutkan ulasan terbaru di atas --}}
                            <div class="border border-gray-200 p-4 mb-3 rounded-lg bg-gray-50 flex justify-between items-start">
                                <div>
                                    <span class="font-semibold text-gray-800">{{ $review->user->name }}</span>
                                    <p class="text-gray-700 mt-1">{{ $review->comment }}</p>
                                    <span class="text-gray-500 text-xs mt-2 block">{{ $review->created_at->diffForHumans() }}</span> {{-- Tampilkan waktu ulasan --}}
                                </div>

                                <div class="flex flex-col items-end gap-1">
                                    <span class="text-yellow-500 text-lg font-bold">{{ $review->rating }} ⭐</span>

                                    @if ($review->user_id === $userId)
                                        <div class="flex gap-2 text-sm mt-2">
                                            <a href="{{ route('reviews.edit', $review->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>

                                            <form action="{{ route('reviews.destroy', $review->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada ulasan untuk mobil ini.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-xl text-gray-600">Tidak ada mobil yang tersedia untuk diulas saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>