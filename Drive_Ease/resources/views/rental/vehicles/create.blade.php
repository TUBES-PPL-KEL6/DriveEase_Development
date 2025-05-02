@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Tambah Kendaraan</h2>

    <form method="POST" action="{{ route('rental.vehicles.store') }}"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <input type="text" name="name" placeholder="Nama Kendaraan"
               class="w-full border p-2 rounded" required>

        <input type="text" name="location" placeholder="Lokasi"
               class="w-full border p-2 rounded" required>

        <select name="category" class="w-full border p-2 rounded">
            <option value="">Pilih Kategori</option>
            <option value="SUV">SUV</option>
            <option value="MPV">MPV</option>
            <option value="Sedan">Sedan</option>
            <option value="Hatchback">Hatchback</option>
        </select>

        <input type="number" name="price_per_day" placeholder="Harga per Hari"
               class="w-full border p-2 rounded" required>

        <textarea name="description" placeholder="Deskripsi Kendaraan"
                  class="w-full border p-2 rounded"></textarea>

        <label class="block">
            <input type="checkbox" name="available" value="1" checked>
            Tersedia
        </label>

        <input type="file" name="image" class="w-full border p-2 rounded">

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Kendaraan
        </button>
    </form>
@endsection
