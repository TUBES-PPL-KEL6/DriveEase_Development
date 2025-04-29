@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Daftar Kendaraan</h1>

    <form method="GET" class="flex gap-4 mb-6">
        <input name="location" placeholder="Lokasi" class="border px-2 py-1 rounded w-1/4">
        <select name="category" class="border px-2 py-1 rounded w-1/4">
            <option value="">Kategori</option>
            <option value="SUV">SUV</option>
            <option value="MPV">MPV</option>
            <option value="Hatchback">Hatchback</option>
        </select>
        <input type="number" name="price_min" placeholder="Harga Min" class="border px-2 py-1 rounded w-1/6">
        <input type="number" name="price_max" placeholder="Harga Max" class="border px-2 py-1 rounded w-1/6">
        <button class="bg-blue-500 text-white px-4 rounded hover:bg-blue-600">Cari</button>
    </form>

    @foreach($vehicles as $vehicle)
        <div class="bg-white p-4 shadow rounded mb-4">
            <h3 class="text-xl font-semibold">{{ $vehicle->name }}</h3>
            <p class="text-sm text-gray-600">{{ $vehicle->location }} | {{ $vehicle->category }}</p>
            <p class="text-gray-700 mt-2">Rp{{ number_format($vehicle->price_per_day) }}/hari</p>
            <a href="{{ route('vehicles.show', $vehicle->id) }}"
               class="inline-block mt-3 text-sm text-blue-500 hover:underline">Lihat Detail</a>
        </div>
    @endforeach
@endsection
