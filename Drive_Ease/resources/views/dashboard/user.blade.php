@extends('layouts.app')

@section('styles')
    {{-- Hapus CSS umum yang ada di sini karena kita akan menggunakan Tailwind CSS secara ekstensif.
         Jika ada CSS kustom yang tidak bisa diwakili Tailwind, baru letakkan di sini.
    --}}
@endsection

@section('content')
    <div class="py-8 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8"> {{-- Padding dan jarak antar bagian --}}
            
            {{-- Header Dashboard --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                    Dashboard Pelanggan
                </h2>
                {{-- Anda bisa menambahkan breadcrumbs atau info tambahan di sini jika diperlukan --}}
            </div>

            {{-- Welcome Section & Quick Actions --}}
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xl text-gray-700">Selamat datang, <span class="font-extrabold text-blue-600">{{ auth()->user()->name }}</span>!</p>
                </div>

                <p class="text-gray-600 mb-6">Kelola pemesanan Anda, temukan kendaraan baru, dan nikmati kemudahan bersama DriveEase.</p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('vehicles.index') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 text-center font-semibold shadow-md transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari Kendaraan Baru
                    </a>
                    <form method="POST" action="{{ route('checkout') }}" class="inline-block w-full sm:w-auto">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-300 text-center font-semibold shadow-md transform hover:scale-105 w-full">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Lanjutkan Checkout
                        </button>
                    </form>
                </div>
            </div>

            {{-- Bagian Status Pembayaran Terakhir --}}
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-xl lg:text-2xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-indigo-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002.92 12c0 1.57.413 3.072 1.15 4.355L4.475 18H20.025l.325-1.645A12.001 12.001 0 0021.08 12c0-1.57-.413-3.072-1.15-4.355z"></path></svg>
                    Status Pembayaran Terakhir
                </h2>
                @if($bookings->count() > 0 && isset($bookings[0]))
                    @php $latestBooking = $bookings[0]; @endphp
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full w-full text-sm">
                            <thead class="bg-slate-100 text-slate-600">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kendaraan</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Mulai</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Selesai</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200 text-slate-700">
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-900">{{ $latestBooking->vehicle->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $latestBooking->vehicle->category ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($latestBooking->start_date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($latestBooking->end_date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $status = strtolower($latestBooking->status);
                                            $statusText = ucfirst($status);
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                            if (in_array($status, ['pending', 'menunggu'])) {
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                                $statusText = 'Menunggu Pembayaran';
                                            } elseif (in_array($status, ['paid', 'lunas', 'konfirmasi', 'confirmed'])) {
                                                $statusClass = 'bg-green-100 text-green-800';
                                                $statusText = 'Lunas / Terkonfirmasi';
                                            } elseif (in_array($status, ['failed', 'gagal', 'ditolak'])) {
                                                $statusClass = 'bg-red-100 text-red-800';
                                                $statusText = 'Gagal / Ditolak';
                                            } elseif (in_array($status, ['cancelled', 'batal'])) {
                                                $statusClass = 'bg-orange-100 text-orange-800';
                                                $statusText = 'Dibatalkan';
                                            } elseif ($status === 'selesai') {
                                                $statusClass = 'bg-blue-100 text-blue-800';
                                            }
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-6 px-4 bg-slate-50 rounded-lg border border-slate-200">
                        <svg class="mx-auto h-10 w-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <p class="text-sm text-slate-600">Belum ada data pembayaran yang tercatat.</p>
                    </div>
                @endif
            </div>

            {{-- Bagian Riwayat Rental --}}
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-xl lg:text-2xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Riwayat Rental Anda
                </h2>
                @if($bookings->count() > 0)
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full w-full text-sm">
                            <thead class="bg-slate-100 text-slate-600">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kendaraan</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Mulai</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Selesai</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status Rental</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th> {{-- Kolom Aksi --}}
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200 text-slate-700">
                                @foreach($bookings as $booking)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="font-medium text-slate-900">{{ $booking->vehicle->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $booking->vehicle->category ?? '' }}</div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @php
                                                $rentalStatus = strtolower($booking->status);
                                                $rentalStatusText = ucfirst($rentalStatus);
                                                $rentalStatusClass = 'bg-gray-100 text-gray-800';

                                                if (in_array($rentalStatus, ['pending', 'menunggu'])) {
                                                    $rentalStatusClass = 'bg-yellow-100 text-yellow-800';
                                                } elseif (in_array($rentalStatus, ['confirmed', 'konfirmasi'])) {
                                                    $rentalStatusClass = 'bg-sky-100 text-sky-800';
                                                } elseif (in_array($rentalStatus, ['active', 'berjalan', 'on_going'])) {
                                                    $rentalStatusClass = 'bg-blue-100 text-blue-800';
                                                } elseif (in_array($rentalStatus, ['completed', 'selesai'])) {
                                                    $rentalStatusClass = 'bg-green-100 text-green-800';
                                                } elseif (in_array($rentalStatus, ['cancelled', 'batal', 'rejected', 'ditolak'])) {
                                                    $rentalStatusClass = 'bg-red-100 text-red-800';
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rentalStatusClass }}">
                                                {{ $rentalStatusText }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <a href="{{ route('user.rents.show', $booking->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline text-xs font-medium inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination links jika ada untuk $bookings --}}
                    {{-- @if ($bookings->hasPages())
                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @endif --}}
                @else
                    <div class="text-center py-6 px-4 bg-slate-50 rounded-lg border border-slate-200">
                        <svg class="mx-auto h-10 w-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-sm text-slate-600">Belum ada riwayat rental kendaraan.</p>
                    </div>
                @endif
            </div>

            {{-- Rekomendasi Kendaraan Lainnya --}}
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-xl lg:text-2xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-purple-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Rekomendasi Kendaraan Lainnya
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($vehicles as $vehicle)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg shadow-sm overflow-hidden transform transition duration-300 hover:scale-[1.02] hover:shadow-md">
                            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="block">
                                @if($vehicle->image_path)
                                    <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <img src="https://placehold.co/400x300/E2E8F0/94A3B8?text=Gambar+Mobil" alt="Tidak ada gambar"
                                        class="w-full h-48 object-cover bg-gray-200 flex items-center justify-center text-gray-500">
                                @endif
                            </a>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-800 mb-1">
                                    <a href="{{ route('vehicles.show', $vehicle->id) }}" class="hover:text-blue-600 transition">{{ $vehicle->name }}</a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $vehicle->category ?? 'N/A' }} &bull; {{ $vehicle->location ?? 'N/A' }}</p> {{-- Menggunakan category dan location --}}
                                <p class="font-bold text-blue-600 text-xl mb-4">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/ Hari</span></p>
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="block text-center bg-blue-600 text-white py-2.5 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold shadow-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-6 px-4 bg-slate-50 rounded-lg border border-slate-200">
                            <svg class="mx-auto h-10 w-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-slate-600">Tidak ada rekomendasi kendaraan saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div> {{-- Penutup div rekomendasi --}}
        </div>
    </div>
@endsection