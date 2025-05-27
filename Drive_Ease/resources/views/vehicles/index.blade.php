@extends('layouts.app')

@section('content')
<h1 style="font-size: 2rem; color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold">Cari Kendaraan</h1><br>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <input name="location" placeholder="Lokasi" value="{{ request('location') }}"
               class="bg-dark border rounded px-3 py-2" />
        <select name="category" class="bg-dark border rounded px-3 py-2">
            <option value="">Kategori</option>
            @foreach(['SUV', 'MPV', 'Sedan', 'Hatchback'] as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <input type="number" name="price_min" placeholder="Harga Min" value="{{ request('price_min') }}"
               class="bg-dark border rounded px-3 py-2" />
        <input type="number" name="price_max" placeholder="Harga Max" value="{{ request('price_max') }}"
               class="bg-dark border rounded px-3 py-2" />

        <button type="submit" class="col-span-1 md:col-span-4 bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Cari Kendaraan
        </button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($vehicles as $vehicle)
            <div class="bg-dark shadow rounded overflow-hidden">
                @if($vehicle->image_path)
                    <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                         class="w-full h-40 object-cover">
                @endif

                <div class="bg-dark p-4">
                    <h3 class="text-lg font-semibold">{{ $vehicle->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $vehicle->location }} - {{ $vehicle->category }}</p>
                    <p class="text-blue-600 font-bold mt-1">Rp{{ number_format($vehicle->price_per_day) }}/hari</p>
                    <a href="{{ route('vehicles.show', $vehicle->id) }}"
                       class="inline-block mt-3 text-blue-500 hover:underline text-sm">Lihat Detail</a>
                </div>
            </div>
        @empty
            <p class="text-gray-600 col-span-3">Tidak ada kendaraan ditemukan.</p>
        @endforelse
    </div>
@endsection
