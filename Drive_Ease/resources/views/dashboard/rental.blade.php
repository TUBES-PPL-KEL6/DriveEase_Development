@extends('layouts.app')

@section('styles')
    <style>
        table, th, td { border: none !important; }
        table { border-collapse: collapse; }
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
    <h2 class="font-semibold text-2xl leading-tight text-gray-800 mb-6">Dashboard Pemilik Rental</h2> {{-- Ubah warna dan ukuran font --}}
{{-- </x-slot> --}}

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-md"> {{-- Ubah bg-dark menjadi bg-white --}}
            <p class="text-gray-700 text-lg mb-4">Selamat datang, <span class="font-bold text-blue-600">{{ auth()->user()->name }}</span>!</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 mb-8"> {{-- Perlebar gap dan tambahkan margin bottom --}}
                <div class="bg-blue-50 p-4 rounded-lg shadow-sm border border-blue-200"> {{-- Warna background yang lebih terang --}}
                    <p class="text-sm text-gray-600 mb-1">Total Pemesanan</p>
                    <h2 class="text-3xl font-bold text-blue-800">{{ $totalBookings }}</h2>
                </div>
                <div class="bg-green-50 p-4 rounded-lg shadow-sm border border-green-200">
                    <p class="text-sm text-gray-600 mb-1">Total Pendapatan</p>
                    <h2 class="text-3xl font-bold text-green-700">Rp{{ number_format($totalRevenue) }}</h2>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg shadow-sm border border-purple-200">
                    <p class="text-sm text-gray-600 mb-1">Jumlah Kendaraan Disewakan</p>
                    <h2 class="text-3xl font-bold text-purple-700">{{ auth()->user()->vehicles->count() }}</h2>
                </div>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mt-6 mb-4">Top 5 Kendaraan Paling Banyak Disewa</h3> {{-- Ubah ukuran font --}}
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg border border-gray-200">
    {{-- Judul untuk konteks tabel, jika diperlukan --}}
    {{-- <h3 class="text-lg font-semibold text-gray-800 mb-4">Kendaraan Paling Banyak Disewa</h3> --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full w-full text-sm">
            <thead class="bg-slate-100 text-slate-600">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Kendaraan</th>
                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Jumlah Disewa</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200 text-slate-700">
                @forelse($mostRentedVehicles as $vehicle)
                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-900">{{ $vehicle->name }}</div>
                            {{-- Jika ada info tambahan seperti kategori, bisa ditambahkan di sini
                            <div class="text-xs text-slate-500">{{ $vehicle->category ?? 'N/A' }}</div>
                            --}}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <span class="font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">
                                {{ $vehicle->bookings_count }}x
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-10 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="font-semibold text-lg text-slate-700">Belum Ada Data</p>
                                <p class="text-sm">Saat ini belum ada data penyewaan kendaraan yang tercatat.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Pagination links jika ada dan diperlukan untuk $mostRentedVehicles
    @if ($mostRentedVehicles->hasPages())
        <div class="mt-6">
            {{ $mostRentedVehicles->links() }}
        </div>
    @endif
    --}}
</div>

            <hr class="my-8 border-gray-200"> {{-- Ubah warna dan margin --}}

            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Kendaraan Anda</h3>
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg border border-gray-200">
    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full w-full text-sm">
            <thead class="bg-blue-50 text-blue-700">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Kendaraan</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Lokasi</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Harga/Hari</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                @forelse(auth()->user()->vehicles as $vehicle)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $vehicle->name }}</div>
                            <div class="text-xs text-gray-500">{{ $vehicle->category ?? 'N/A' }}</div> {{-- Tambahkan info kategori jika ada --}}
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $vehicle->location }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-800 font-medium">
                            Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($vehicle->available)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Tidak Tersedia
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center items-center space-x-2 rtl:space-x-reverse">
                                <a href="{{ route('rental.vehicles.edit', $vehicle->id) }}"
                                   class="inline-flex items-center justify-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                <form action="{{ route('rental.vehicles.destroy', $vehicle->id) }}" method="POST"
                                      class="inline-block" {{-- Membuat form inline agar sejajar dengan tombol edit --}}
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan {{ $vehicle->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="font-semibold text-lg">Belum Ada Kendaraan</p>
                                <p class="text-sm">Anda belum menambahkan kendaraan apapun ke daftar rental Anda.</p>
                                {{-- Opsional: Tombol untuk menambah kendaraan jika ini adalah halaman manajemen rental
                                <a href="{{ route('rental.vehicles.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    + Tambah Kendaraan
                                </a>
                                --}}
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Pagination links jika ada
    @if (auth()->user()->vehicles()->hasPages())
        <div class="mt-6">
            {{ auth()->user()->vehicles()->links() }}
        </div>
    @endif
    --}}
</div>

            <div class="mt-6"> {{-- Ubah margin top --}}
                <a href="{{ route('rental.vehicles.create') }}"
                   class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 text-center font-semibold shadow-md">
                    + Tambah Kendaraan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection