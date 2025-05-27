@extends('layouts.app')

@section('content')
    <h2 class="text-xl font-bold mb-4">Edit Kendaraan</h2>

    <form method="POST" enctype="multipart/form-data" action="{{ route('rental.vehicles.update', $vehicle->id) }}"
        class="space-y-4">
        @csrf
        @method('PUT')

        <input type="file" name="image" class="w-full border p-2 rounded">
        <input type="text" name="name" value="{{ $vehicle->name }}" required class="w-full border p-2 rounded">
        <input type="text" name="location" value="{{ $vehicle->location }}" required class="w-full border p-2 rounded">

        <select name="category" class="w-full border p-2 rounded">
            @foreach (['SUV', 'MPV', 'Sedan', 'Hatchback'] as $cat)
                <option value="{{ $cat }}" {{ $vehicle->category === $cat ? 'selected' : '' }}>{{ $cat }}
                </option>
            @endforeach
        </select>

        <input type="number" name="price_per_day" value="{{ $vehicle->price_per_day }}" required
            class="w-full border p-2 rounded">
        <textarea name="description" class="w-full border p-2 rounded">{{ $vehicle->description }}</textarea>

        <label>
            <input type="checkbox" name="available" value="1" {{ $vehicle->available ? 'checked' : '' }}> Tersedia
        </label>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
    </form>
@endsection
