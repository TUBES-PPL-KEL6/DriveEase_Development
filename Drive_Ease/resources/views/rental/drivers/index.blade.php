@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <h1 class="text-2xl font-bold text-left my-6">Daftar Driver</h1>

    <div class="flex justify-left mb-6">
        <a href="{{ route('rental.drivers.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Tambah Driver
        </a>
    </div>

    <div class="space-y-4">
        @foreach($drivers as $driver)
        <div class="bg-white rounded-lg shadow-md p-4 flex justify-between items-start">
            <!-- Info driver -->
            <div>
                <h2 class="text-lg font-semibold">{{ $driver->name }}</h2>
                <p class="text-sm text-gray-600">Telepon: {{ $driver->phone }}</p>
                <p class="text-sm text-gray-600">Status: {{ $driver->status }}</p>
                <p class="text-sm text-gray-600">Jadwal: {{ $driver->schedule ?? '-' }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection