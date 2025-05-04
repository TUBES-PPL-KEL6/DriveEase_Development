@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded p-6">
    {{-- Gambar dan Info Kendaraan --}}
    @if($vehicle->image_path)
        <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
             class="w-full h-64 object-cover mb-4 rounded">
    @endif

    <h2 class="text-2xl font-bold">{{ $vehicle->name }}</h2>
    <p class="text-gray-500">{{ $vehicle->location }} - {{ $vehicle->category }}</p>
    <p class="text-blue-600 text-lg font-bold mt-2">Rp{{ number_format($vehicle->price_per_day) }}/hari</p>

    {{-- Rating Rata-rata --}}
    <div class="mt-2">
        @if($vehicle->average_rating)
            <div class="flex items-center gap-1 text-yellow-500">
                @for ($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= round($vehicle->average_rating) ? 'orange' : 'none' }}"
                         viewBox="0 0 24 24" stroke="orange" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.234 6.869h7.215c.969 0 1.371 1.24.588 1.81l-5.838 4.245
                                 2.234 6.869c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.838 4.245c-.783.57-1.838-.197-1.538-1.118l2.234-6.869
                                 -5.838-4.245c-.783-.57-.38-1.81.588-1.81h7.215l2.234-6.869z"/>
                    </svg>
                @endfor
                <span class="text-sm text-gray-600 ml-2">({{ number_format($vehicle->average_rating, 1) }})</span>
            </div>
        @else
            <p class="text-gray-400 italic">Belum ada rating</p>
        @endif
    </div>

    {{-- Deskripsi --}}
    <div class="mt-4">
        <h3 class="text-lg font-semibold">Deskripsi</h3>
        <p class="text-gray-700">{{ $vehicle->description }}</p>
    </div>

    {{-- Form Pemesanan --}}
    @auth
        @if(auth()->user()->role === 'pelanggan')
            <div class="mt-6 border-t pt-4">
                <h3 class="text-lg font-semibold mb-2">Form Pemesanan</h3>
                <form action="{{ route('user.bookings.store', $vehicle->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="border rounded px-3 py-2 w-full" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="border rounded px-3 py-2 w-full" required>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Pesan Sekarang
                    </button>
                </form>
            </div>
        @endif
    @endauth

    
    {{-- Ulasan Pengguna --}}
    <div class="mt-8 border-t pt-4">
        <h3 class="text-lg font-semibold mb-4">Ulasan Pengguna</h3>

        @auth
            @php
                $userReview = $vehicle->reviews->firstWhere('user_id', auth()->id());
                $editMode = request()->query('edit') === 'true';
            @endphp

            @if (!$userReview)
                {{-- Belum Ulasan: Form Baru --}}
                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-3 mb-4">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    <div>
                        <label class="block text-sm font-medium">Rating</label>
                        <select name="rating" class="border rounded px-2 py-1 w-full">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} ⭐</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Komentar</label>
                        <textarea name="comment" rows="3" class="border rounded w-full px-2 py-1" required></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Ulasan</button>
                </form>
            @elseif ($editMode)
                {{-- Edit Mode: Tampilkan Form --}}
                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
                    <form action="{{ route('reviews.update', $userReview->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        <div class="mb-2">
                            <label class="text-sm font-medium">Rating</label>
                            <select name="rating" class="w-full border rounded px-2 py-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $userReview->rating == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="text-sm font-medium">Komentar</label>
                            <textarea name="comment" rows="3" class="w-full border rounded px-2 py-1">{{ $userReview->comment }}</textarea>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Update</button>
                        </div>
                    </form>
                </div>
            @endif
        @endauth

        {{-- Semua Ulasan --}}
        <div class="space-y-3">
            @forelse ($vehicle->reviews as $review)
                <div class="bg-gray-100 p-4 rounded border relative">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-sm">{{ $review->user->name }}</p>
                            <p class="text-gray-700 mt-1 text-sm">{{ $review->comment }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-yellow-500 text-sm font-medium">{{ $review->rating }} ⭐</span>

                            @if ($review->user_id === auth()->id())
                                <div class="flex gap-2 text-xs">
                                    <a href="{{ request()->url() }}?edit=true" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin hapus ulasan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada ulasan untuk kendaraan ini.</p>
            @endforelse
        </div>
    </div>



</div>
@endsection
