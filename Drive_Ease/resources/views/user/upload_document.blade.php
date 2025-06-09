@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Upload Dokumen Identitas</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.upload.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="ktp" class="block font-medium text-gray-700">Upload KTP</label>
            <input type="file" name="ktp" id="ktp" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm file:bg-blue-500 file:text-white file:border-none file:px-4 file:py-2 file:rounded hover:file:bg-blue-600" />
        </div>

        <div>
            <label for="sim" class="block font-medium text-gray-700">Upload SIM</label>
            <input type="file" name="sim" id="sim" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm file:bg-blue-500 file:text-white file:border-none file:px-4 file:py-2 file:rounded hover:file:bg-blue-600" />
        </div>

        <div class="text-center">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                Kirim Dokumen
            </button>
        </div>
    </form>
</div>
@endsection
