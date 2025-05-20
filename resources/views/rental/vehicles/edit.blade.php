@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Kendaraan</h2>

<form method="POST" enctype="multipart/form-data" action="{{ route('rental.vehicles.update', $vehicle->id) }}" class="space-y-4">
    @csrf
    @method('PUT')

    @if($vehicle->photos && $vehicle->photos->count())
        <div class="mb-2 flex flex-wrap gap-2">
            @foreach($vehicle->photos as $photo)
                <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-24 h-24 object-cover rounded shadow" alt="Foto Kendaraan">
            @endforeach
        </div>
    @endif
    <label class="block font-medium">Tambah Foto Kendaraan (bisa lebih dari satu)</label>
    <input type="file" name="photos[]" class="w-full border p-2 rounded" multiple accept="image/*">
    <div id="preview-photos" class="flex flex-wrap gap-2 mt-2"></div>

    <input type="text" name="name" value="{{ $vehicle->name }}" required class="w-full border p-2 rounded">
    <input type="text" name="location" value="{{ $vehicle->location }}" required class="w-full border p-2 rounded">
    
    <select name="category" class="w-full border p-2 rounded">
        @foreach(['SUV', 'MPV', 'Sedan', 'Hatchback'] as $cat)
            <option value="{{ $cat }}" {{ $vehicle->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>

    <input type="number" name="price_per_day" value="{{ $vehicle->price_per_day }}" required class="w-full border p-2 rounded">
    <textarea name="description" class="w-full border p-2 rounded">{{ $vehicle->description }}</textarea>

    <label>
        <input type="checkbox" name="available" value="1" {{ $vehicle->available ? 'checked' : '' }}> Tersedia
    </label>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
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
