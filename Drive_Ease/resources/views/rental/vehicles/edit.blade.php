@extends('layouts.app')

@section('content')
<div class="py-10 px-4 md:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Edit Kendaraan</h2>
            <a href="{{ route('rental.vehicles.index') }}" 
               class="text-sm text-gray-600 hover:text-blue-600 hover:underline flex items-center">
                <svg class="w-4 h-4 mr-1 rtl:ml-1 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
        </div>

        <form method="POST" action="{{ route('rental.vehicles.update', $vehicle->id) }}"
              enctype="multipart/form-data"
              class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kendaraan</label>
                <input type="text" name="name" id="name" placeholder="Contoh: Avanza, Xpander, Brio"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" 
                       value="{{ old('name', $vehicle->name) }}" required>
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kendaraan</label>
                <input type="text" name="location" id="location" placeholder="Contoh: Jakarta Selatan, Bandung Kota"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" 
                       value="{{ old('location', $vehicle->location) }}" required>
                @error('location') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" required>
                    <option value="" disabled>Pilih Kategori</option>
                    @php $categories = ['SUV', 'MPV', 'Sedan', 'Hatchback', 'LCGC', 'City Car', 'Van', 'Lainnya']; @endphp
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $vehicle->category) === $cat ? 'selected' : '' }}>
                            {{ $cat }}{{ $cat === 'SUV' ? ' (Sport Utility Vehicle)' : ($cat === 'MPV' ? ' (Multi-Purpose Vehicle)' : ($cat === 'LCGC' ? ' (Low Cost Green Car)' : '')) }}
                        </option>
                    @endforeach
                </select>
                @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="price_per_day" class="block text-sm font-medium text-gray-700 mb-1">Harga per Hari (Rp)</label>
                <input type="number" name="price_per_day" id="price_per_day" placeholder="Contoh: 350000"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" 
                       value="{{ old('price_per_day', $vehicle->price_per_day) }}" required min="0">
                @error('price_per_day') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kendaraan</label>
                <textarea name="description" id="description" placeholder="Jelaskan kondisi, fitur unggulan, atau informasi tambahan lainnya..."
                          rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm">{{ old('description', $vehicle->description) }}</textarea>
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Kendaraan</label>
                @if($vehicle->image_path)
                    <div class="my-2">
                        <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="Gambar Saat Ini: {{ $vehicle->name }}" class="h-32 w-auto object-cover rounded-md shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini. Pilih file baru untuk mengganti.</p>
                    </div>
                @endif
                <input type="file" name="image" id="image" 
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex items-center pt-2">
                <input type="checkbox" name="available" id="available" value="1" {{ old('available', $vehicle->available) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="available" class="ml-2 block text-sm text-gray-900">Tersedia untuk disewa</label>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full inline-flex justify-center py-2.5 px-6 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    Update Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection