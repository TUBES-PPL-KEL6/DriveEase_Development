@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Kendaraan Saya</h2>

    <a href="{{ route('rental.vehicles.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-6 inline-block">
        + Tambah Kendaraan
    </a>

    @foreach($vehicles as $vehicle)
        <div class="bg-white shadow rounded p-4 mb-4">
            <div class="flex items-center gap-4">
                @if($vehicle->image_path)
                    <img src="{{ asset('storage/' . $vehicle->image_path) }}"
                         class="w-32 h-20 object-cover rounded shadow" alt="{{ $vehicle->name }}">
                @endif

                <div class="flex-grow">
                    <h3 class="text-lg font-semibold">{{ $vehicle->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $vehicle->category }} - {{ $vehicle->location }}</p>
                    <p class="text-gray-700 font-medium">Rp{{ number_format($vehicle->price_per_day) }}/hari</p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('rental.vehicles.edit', $vehicle->id) }}"
                       class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('rental.vehicles.destroy', $vehicle->id) }}" method="POST"
                          onsubmit="return confirm('Hapus kendaraan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
