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

        <label class="block font-medium">Foto Kendaraan (bisa lebih dari satu)</label>
        <input type="file" name="photos[]" class="w-full border p-2 rounded" multiple accept="image/*">
        <div id="preview-photos" class="flex flex-wrap gap-2 mt-2"></div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Kendaraan
        </button>
    </form>
@endsection

@push('scripts')
<script>
    document.querySelector('input[name="photos[]"]')?.addEventListener('change', function(e) {
        const preview = document.getElementById('preview-photos');
        preview.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'w-24 h-24 object-cover rounded shadow';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
