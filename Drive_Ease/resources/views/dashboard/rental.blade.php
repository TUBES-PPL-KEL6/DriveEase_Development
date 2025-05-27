@extends('layouts.app')

@section('styles')
    <style>
        table, th, td { border: none !important; }
        table { border-collapse: collapse; }
    </style>
@endsection

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-white leading-tight">Dashboard Pemilik Rental</h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-dark text-white p-6 rounded-md">
            <p>Selamat datang, <span style="color:#00ffae;">{{ auth()->user()->name }}</span>!</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-gray-800 p-4 rounded shadow">
                    <p class="text-sm text-gray-400">Total Pemesanan</p>
                    <h2 class="text-2xl font-bold text-white">{{ $totalBookings }}</h2>
                </div>
                <div class="bg-gray-800 p-4 rounded shadow">
                    <p class="text-sm text-gray-400">Total Pendapatan</p>
                    <h2 class="text-2xl font-bold text-green-400">Rp{{ number_format($totalRevenue) }}</h2>
                </div>
                <div class="bg-gray-800 p-4 rounded shadow">
                    <p class="text-sm text-gray-400">Jumlah Kendaraan Disewakan</p>
                    <h2 class="text-2xl font-bold text-white">{{ auth()->user()->vehicles->count() }}</h2>
                </div>
            </div>
            <br>
            <h3 class="text-white text-lg mt-6 mb-2" style="color:#00ffae;">Top 5 Kendaraan Paling Banyak Disewa</h3>
            <table class="table w-full text-sm">
                <thead style="background-color: #00ffae; font-weight: bold;">
                    <tr>
                        <th>Nama Kendaraan</th>
                        <th>Jumlah Disewa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mostRentedVehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->bookings_count }}x</td>
                        </tr>
                    @empty
                        <tr><td colspan="2">Belum ada data penyewaan.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <hr class="my-6 border-gray-600">

<h3 class="text-lg font-bold text-white mb-2">Daftar Kendaraan Anda</h3>
<table class="w-full text-white text-sm table-auto">
    <thead style="background-color: #00ffae;">
        <tr>
            <th class="text-left p-2">Nama</th>
            <th class="text-left p-2">Lokasi</th>
            <th class="text-left p-2">Harga/Hari</th>
            <th class="text-left p-2">Status</th>
            <th class="text-left p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse(auth()->user()->vehicles as $vehicle)
            <tr class="border-b border-gray-700">
                <td class="p-2">{{ $vehicle->name }}</td>
                <td class="p-2">{{ $vehicle->location }}</td>
                <td class="p-2">Rp{{ number_format($vehicle->price_per_day) }}</td>
                <td class="p-2">
                    @if($vehicle->available)
                        <span class="text-green-400 font-semibold">Tersedia</span>
                    @else
                        <span class="text-red-400 font-semibold">Tidak Tersedia</span>
                    @endif
                </td>
                <td class="p-2">
                    <a href="{{ route('rental.vehicles.edit', $vehicle->id) }}" class="text-blue-400 hover:underline">Edit</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="p-2">Belum ada kendaraan.</td></tr>
        @endforelse
    </tbody>
</table>

            <div class="mt-4">
    <a href="{{ route('rental.vehicles.create') }}"
       class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + Tambah Kendaraan
    </a>
</div>

        </div>
    </div>
</div>
@endsection
