@extends('layouts.app')

@section('styles')
    <style>
        /* CSS Umum untuk tabel */
        table, th, td {
            border: none !important; /* Hapus border Bootstrap */
        }
        table {
            border-collapse: collapse; /* Pastikan collapse */
        }
        /* Tambahan styling untuk sel header table agar teks hitam */
        thead th {
            color: #334155 !important; /* Warna teks gelap */
        }
        tbody tr:nth-child(even) {
            background-color: #f8fafc; /* Warna background untuk baris genap */
        }
        tbody tr:hover {
            background-color: #eff6ff; /* Warna background saat hover */
        }
    </style>
@endsection

@section('content')
    {{-- <x-slot name="header"> --}}
        <h2 class="font-semibold text-2xl leading-tight text-gray-800 mb-6"> {{-- Ubah dari text-xl menjadi text-2xl dan tambahkan mb-6 --}}
            Dashboard Pelanggan
        </h2>
    {{-- </x-slot> --}} {{-- x-slot biasanya digunakan di komponen layout, bukan di @section content --}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> {{-- Ubah space-y-4 menjadi space-y-6 untuk jarak antar bagian --}}
            <div class="bg-white p-6 rounded-lg shadow-md"> {{-- Ubah bg-dark menjadi bg-white --}}
                <p class="text-gray-700 text-lg mb-4">Selamat datang, <span class="font-bold text-blue-600">{{ auth()->user()->name }}</span>!</p> {{-- Ubah warna teks --}}

                <div class="flex flex-col md:flex-row gap-4 mb-8"> {{-- Gunakan flexbox untuk tombol, tambahkan gap dan margin bottom --}}
                    <a href="{{ route('vehicles.index') }}"
                       class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 text-center font-semibold shadow-md">
                        Cari Kendaraan
                    </a>
                    <form method="POST" action="{{ route('checkout') }}" class="inline-block">
                        @csrf
                        <button type="submit"
                                class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300 text-center font-semibold shadow-md">
                            Checkout
                        </button>
                    </form>
                </div>

                {{-- Asumsi ini adalah pembungkus utama untuk kedua bagian ini, seperti kartu di dashboard --}}
<div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 space-y-8">

    {{-- Bagian Status Pembayaran Terakhir --}}
    <div>
        <h2 class="text-xl lg:text-2xl font-semibold text-gray-800 mb-4">Status Pembayaran Terakhir</h2>
        @if($bookings->count() > 0 && isset($bookings[0])) {{-- Pastikan $bookings[0] ada --}}
            @php $latestBooking = $bookings[0]; @endphp {{-- Asumsi $bookings[0] adalah yang terbaru --}}
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
                        <tr>
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
                                    $statusClass = 'bg-gray-100 text-gray-800'; // Default
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
                                        $statusClass = 'bg-orange-100 text-orange-800'; // Atau warna lain untuk batal
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
    <div>
        <h2 class="text-xl lg:text-2xl font-semibold text-gray-800 mb-4">Riwayat Rental Anda</h2>
        @if($bookings->count() > 0)
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="min-w-full w-full text-sm">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kendaraan</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Mulai</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Selesai</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status Rental</th>
                            {{-- Opsional: Tambah kolom aksi jika user bisa lihat detail atau review --}}
                            {{-- <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th> --}}
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
                                        $rentalStatusClass = 'bg-gray-100 text-gray-800'; // Default

                                        // Sesuaikan dengan status rental yang mungkin ada di sistem Anda
                                        if (in_array($rentalStatus, ['pending', 'menunggu'])) {
                                            $rentalStatusClass = 'bg-yellow-100 text-yellow-800';
                                        } elseif (in_array($rentalStatus, ['confirmed', 'konfirmasi'])) {
                                            $rentalStatusClass = 'bg-sky-100 text-sky-800'; // Biru langit untuk konfirmasi rental
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
                                {{-- 
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline text-xs font-medium">Lihat Detail</a>
                                </td>
                                --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Pagination links jika ada untuk $bookings
            @if ($bookings->hasPages())
                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            @endif
            --}}
        @else
            <div class="text-center py-6 px-4 bg-slate-50 rounded-lg border border-slate-200">
                 <svg class="mx-auto h-10 w-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-sm text-slate-600">Belum ada riwayat rental kendaraan.</p>
            </div>
        @endif
    </div>

</div>

            <div class="bg-white p-6 rounded-lg shadow-md mt-6"> {{-- Tambahkan div baru untuk rekomendasi --}}
                <h2 class="font-bold text-2xl text-gray-800 mb-4">Rekomendasi Kendaraan Lainnya</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($vehicles as $vehicle)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg shadow-sm overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-md">
                            @if($vehicle->image_path)
                                <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                                     class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                                    Tidak ada gambar
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-800">{{ $vehicle->name }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $vehicle->type }} - {{ $vehicle->capacity }} Kursi</p>
                                <p class="font-bold text-blue-600 text-xl mb-4">Rp{{ number_format($vehicle->price_per_day) }} / Hari</p>
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="block text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-gray-600">Tidak ada rekomendasi kendaraan saat ini.</p>
                    @endforelse
                </div>
            </div> {{-- Penutup div rekomendasi --}}
        </div>
    </div>
@endsection