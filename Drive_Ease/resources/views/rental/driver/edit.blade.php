@extends('layouts.app')

@section('content')
    <div class="py-8 px-4 md:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('rental.drivers.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-dark rounded-lg border border-gray-600 
               text-sm font-medium text-gray-300 hover:bg-gray-800 
               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
               transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="bg-dark rounded-xl shadow-sm border border-gray-700">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-100 mb-6">
                        {{ isset($driver) ? 'Edit Driver' : 'Tambah Driver Baru' }}
                    </h2>

                    <form
                        action="{{ isset($driver) ? route('rental.drivers.update', $driver->id) : route('rental.drivers.store') }}"
                        method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @if (isset($driver))
                            @method('PUT')
                        @endif

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300">Nama Driver</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $driver->name ?? '') }}"
                                class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-300">Nomor Telepon</label>
                            <input type="tel" name="phone" id="phone"
                                value="{{ old('phone', $driver->phone ?? '') }}"
                                class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300">Email (Opsional)</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $driver->email ?? '') }}"
                                class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Photo -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-300">Foto Driver</label>
                            @if (isset($driver) && $driver->photo)
                                <div class="mt-2">
                                    <img src="{{ $driver->photo }}" alt="{{ $driver->name }}"
                                        class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" name="photo" id="photo" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-300
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-gray-700 file:text-gray-200
                                      hover:file:bg-gray-600">
                            @error('photo')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-900 rounded-lg text-blue-200 font-medium border border-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                {{ isset($driver) ? 'Update Driver' : 'Tambah Driver' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
