@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Dashboard Pelanggan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="p-6 rounded-md">
                <div class="space-y-6">
                    @forelse ($bookings as $booking)
                        <div class="bg-dark rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row gap-8">
                                    <!-- Vehicle Image -->
                                    <div class="w-full lg:w-64 h-48 lg:h-40">
                                        <img src="{{ $booking->vehicle->image_url ?? 'https://placehold.co/300x200' }}"
                                            alt="{{ $booking->vehicle->name }}"
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>

                                    <!-- Booking Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-col gap-6">
                                            <!-- Header -->
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-start gap-4">
                                                <h2 class="text-xl font-bold text-white">
                                                    {{ $booking->vehicle->name }}</h2>
                                                <span
                                                    class="inline-flex px-4 py-1.5 rounded-full text-sm font-medium
                                                @if ($booking->status === 'menunggu') bg-yellow-500 text-white
                                                @elseif($booking->status === 'konfirmasi') bg-blue-500 text-white
                                                @elseif($booking->status === 'berjalan') bg-green-500 text-white
                                                @elseif($booking->status === 'selesai') bg-gray-500 text-white
                                                @elseif($booking->status === 'batal') bg-red-500 text-white @endif">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>

                                            <!-- Details Grid -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                                                <div class="space-y-1">
                                                    <p class="text-sm text-gray-400">Tanggal Mulai</p>
                                                    <p class="text-base font-medium text-white">
                                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                                    </p>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-sm text-gray-400">Tanggal Selesai</p>
                                                    <p class="text-base font-medium text-white">
                                                        {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                                    </p>
                                                </div>

                                                @if ($booking->driver)
                                                    <div class="space-y-1">
                                                        <p class="text-sm text-gray-400">Driver</p>
                                                        <span class="flex items-center">
                                                            <svg class="inline-block w-5 h-5 mr-1 text-white" fill="white"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            <p class="text-base font-medium text-white">
                                                                {{ $booking->driver->name }}</p>
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="space-y-1">
                                                        <p class="text-sm text-gray-400">Driver</p>
                                                        <p class="text-base font-medium text-gray-400">Tidak
                                                            Menggunakan Driver
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-6 lg:mt-0 flex lg:flex-col justify-end">
                                        <a href="{{ route('user.bookings.show', $booking->id) }}"
                                            class="w-full lg:w-40 inline-flex items-center justify-center p-2 rounded-lg
                                        bg-blue-600 text-white font-medium hover:bg-blue-700 
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                        transition-all duration-200">
                                            <span>Lihat Detail</span>
                                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-dark border-l-4 border-yellow-400 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base text-yellow-400">
                                        Belum ada data pemesanan yang tersedia
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <br>
                <h2><span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);"
                        class="fw-bold text-2xl">Rekomendasi kendaraan yang lain</span></h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($vehicles as $vehicle)
                        <div class="bg-dark shadow rounded overflow-hidden" style="margin-top: 10px;">
                            @if ($vehicle->image_path)
                                <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                                    class="w-full h-40 object-cover">
                            @endif

                            <div class="bg-dark p-4">
                                <h3 class="text-lg font-semibold">{{ $vehicle->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $vehicle->location }} - {{ $vehicle->category }}</p>
                                <p class="text-blue-600 font-bold mt-1">Rp{{ number_format($vehicle->price_per_day) }}/hari
                                </p>
                                <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                    class="inline-block mt-3 text-blue-500 hover:underline text-sm">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </body>
        @endsection
