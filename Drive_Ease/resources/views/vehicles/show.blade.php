@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow rounded p-6">
        {{-- Gambar Kendaraan --}}
        @if($vehicle->image_path)
            <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                 class="w-full h-64 object-cover mb-4 rounded">
        @endif

        {{-- Info Kendaraan --}}
        <h2 class="text-2xl font-bold">{{ $vehicle->name }}</h2>
        <p class="text-gray-500">{{ $vehicle->location }} - {{ $vehicle->category }}</p>
        <p class="text-blue-600 text-lg font-bold mt-2">Rp{{ number_format($vehicle->price_per_day) }}/hari</p>

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
                        <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Pesan Sekarang
                        </button>
                    </form>
                </div>
            @endif
        @endauth

        {{-- Ulasan dan Rating --}}
        <div class="mt-10 border-t pt-6">
            <h3 class="text-lg font-semibold mb-4">Ulasan Pengguna</h3>

            @if ($vehicle->reviews->count())
                @php
                    $avgRating = round($vehicle->reviews->avg('rating'), 1);
                @endphp

                <p class="text-yellow-600 font-semibold mb-2">
                    Rating Rata-Rata: {{ $avgRating }} ⭐
                </p>

                @foreach ($vehicle->reviews as $review)
                    <div class="border rounded p-3 mb-3 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">{{ $review->user->name }}</span>
                            <span class="text-yellow-500 text-sm">{{ $review->rating }} ⭐</span>
                        </div>
                        <p class="text-gray-700 mt-1">{{ $review->comment }}</p>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 italic">Belum ada ulasan untuk kendaraan ini.</p>
            @endif
        </div>
    </div>
@endsection
