@extends('layouts.app')

@section('styles')
    <style>
        table,
        th,
        td {
            border: none !important;
        }

        table {
            border-collapse: collapse;
        }

        /* Tambahan styling untuk sel header table agar teks hitam */
        thead th {
            color: #334155 !important;
            /* Warna teks gelap */
        }

        tbody tr:nth-child(even) {
            background-color: #f8fafc;
            /* Warna background untuk baris genap */
        }

        tbody tr:hover {
            background-color: #eff6ff;
            /* Warna background saat hover */
        }
    </style>
@endsection


@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md"> {{-- Ubah bg-dark menjadi bg-white --}}
                <p class="text-gray-700 text-lg mb-4">Selamat datang, <span
                        class="font-bold text-blue-600">{{ auth()->user()->name }}</span>!</p>

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

                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-4">Top 5 Kendaraan Paling Banyak Disewa</h3>
                {{-- Ubah ukuran font --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg border border-gray-200">
                    {{-- Judul untuk konteks tabel, jika diperlukan --}}
                    {{-- <h3 class="text-lg font-semibold text-gray-800 mb-4">Kendaraan Paling Banyak Disewa</h3> --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full w-full text-sm">
                            <thead class="bg-slate-100 text-slate-600">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama
                                        Kendaraan</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Jumlah
                                        Disewa</th>
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
                                                <svg class="w-12 h-12 text-slate-400 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <p class="font-semibold text-lg text-slate-700">Belum Ada Data</p>
                                                <p class="text-sm">Saat ini belum ada data penyewaan kendaraan yang
                                                    tercatat.</p>
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
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama
                                        Kendaraan</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Lokasi
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                                        Harga/Hari</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                                @forelse(auth()->user()->vehicles as $vehicle)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">{{ $vehicle->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $vehicle->category ?? 'N/A' }}</div>
                                            {{-- Tambahkan info kategori jika ada --}}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $vehicle->location }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-800 font-medium">
                                            Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if ($vehicle->available)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Tersedia
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Tidak Tersedia
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2 rtl:space-x-reverse">
                                                <a href="{{ route('rental.vehicles.edit', $vehicle->id) }}"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                    <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('rental.vehicles.destroy', $vehicle->id) }}"
                                                    method="POST" class="inline-block" {{-- Membuat form inline agar sejajar dengan tombol edit --}}
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan {{ $vehicle->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                        <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
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
                                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <p class="font-semibold text-lg">Belum Ada Kendaraan</p>
                                                <p class="text-sm">Anda belum menambahkan kendaraan apapun ke daftar rental
                                                    Anda.</p>
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
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('rental.vehicles.create') }}"
                        class="w-full sm:w-auto bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 text-center font-semibold shadow-md flex items-center justify-center">
                        + Tambah Kendaraan
                    </a>
                    <a href="{{ route('rental.drivers.index') }}"
                        class="w-full sm:w-auto bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 text-center font-semibold shadow-md flex items-center justify-center">
                        Kelola Driver
                    </a>
                    <a href="{{ route('rental.history') }}"
                        class="w-full sm:w-auto bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition duration-300 text-center font-semibold shadow-md flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Lihat Riwayat Pemesanan
                    </a>
                </div>
                {{-- Rental to Customer Review Section --}}
                <div class="bg-white p-8 rounded-2xl shadow-xl mt-12 border border-gray-200 max-w-7xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Review Pelanggan <span
                            class="text-base font-normal text-gray-500">(Oleh Rental)</span></h3>
                    @if ($completedBookings->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16">
                            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-700 mb-3">Belum ada pemesanan yang perlu direview
                            </h4>
                            <p class="text-gray-500 text-center max-w-md mb-4">
                                Booking yang sudah selesai akan muncul di sini untuk Anda review.<br>
                                Memberikan review membantu membangun kepercayaan dalam platform kami.
                            </p>
                            <div class="bg-blue-50 rounded-lg p-4 max-w-md">
                                <p class="text-sm text-blue-700">
                                    <strong>💡 Tips:</strong> Review yang konstruktif membantu pelanggan lain dan
                                    meningkatkan reputasi bisnis Anda.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Booking</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pelanggan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kendaraan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Periode Sewa</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($completedBookings as $booking)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">#{{ $booking->id }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $booking->created_at ? $booking->created_at->format('d M Y') : '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                                        <span
                                                            class="text-indigo-600 font-medium text-sm">{{ substr($booking->user->name ?? 'U', 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $booking->user->name ?? '-' }}</div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $booking->user->email ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-medium">
                                                    {{ $booking->vehicle->name ?? '-' }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $booking->vehicle->category ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $booking->start_date ? \Carbon\Carbon::parse($booking->start_date)->format('d M Y') : '-' }}
                                                </div>
                                                <div class="text-xs text-gray-500">sampai
                                                    {{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('d M Y') : '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if ($booking->rentalReview)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
                                                        Sudah Direview
                                                    </span>
                                                @else
                                                    <button type="button"
                                                        onclick="openReviewModal('{{ $booking->id }}')"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                        Review
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- Review Modals --}}
                @if (!$completedBookings->isEmpty())
                    @foreach ($completedBookings as $booking)
                        @if (!$booking->rentalReview)
                            <div id="review-modal-{{ $booking->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto"
                                aria-labelledby="modal-title-{{ $booking->id }}" role="dialog" aria-modal="true"
                                style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5);">
                                <div
                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity"
                                        onclick="closeReviewModal('{{ $booking->id }}')" aria-hidden="true"></div>

                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                        aria-hidden="true">&#8203;</span>

                                    <div
                                        class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex items-center">
                                                    <div
                                                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-indigo-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                            id="modal-title-{{ $booking->id }}">
                                                            Review Pelanggan
                                                        </h3>
                                                        <p class="text-sm text-gray-500">Berikan penilaian untuk pelanggan
                                                            ini</p>
                                                    </div>
                                                </div>
                                                <button type="button" onclick="closeReviewModal('{{ $booking->id }}')"
                                                    class="bg-white rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            {{-- Booking Details --}}
                                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                                <dl class="grid grid-cols-1 gap-2 text-sm">
                                                    <div class="flex justify-between">
                                                        <dt class="font-medium text-gray-500">Booking ID:</dt>
                                                        <dd class="text-gray-900">#{{ $booking->id }}</dd>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <dt class="font-medium text-gray-500">Pelanggan:</dt>
                                                        <dd class="text-gray-900">{{ $booking->user->name ?? '-' }}</dd>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <dt class="font-medium text-gray-500">Email:</dt>
                                                        <dd class="text-gray-900">{{ $booking->user->email ?? '-' }}</dd>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <dt class="font-medium text-gray-500">Kendaraan:</dt>
                                                        <dd class="text-gray-900">{{ $booking->vehicle->name ?? '-' }}
                                                        </dd>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <dt class="font-medium text-gray-500">Periode:</dt>
                                                        <dd class="text-gray-900">
                                                            {{ $booking->start_date ? \Carbon\Carbon::parse($booking->start_date)->format('d M Y') : '-' }}
                                                            -
                                                            {{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('d M Y') : '-' }}
                                                        </dd>
                                                    </div>
                                                </dl>
                                            </div>

                                            {{-- Review Form --}}
                                            <form id="review-form-{{ $booking->id }}"
                                                action="{{ route('rental.reviews.store', $booking) }}" method="POST"
                                                class="space-y-4">
                                                @csrf

                                                {{-- Rating --}}
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        Rating <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="flex items-center space-x-1"
                                                        id="star-rating-{{ $booking->id }}">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <button type="button"
                                                                class="star-btn text-gray-300 hover:text-yellow-400 focus:outline-none focus:text-yellow-400 transition-colors duration-150"
                                                                data-rating="{{ $i }}"
                                                                data-booking="{{ $booking->id }}"
                                                                aria-label="Rating {{ $i }} bintang">
                                                                <svg class="w-8 h-8" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            </button>
                                                        @endfor
                                                    </div>
                                                    <input type="hidden" name="rating" id="rating-{{ $booking->id }}"
                                                        required>
                                                    <p class="mt-1 text-xs text-gray-500">Klik bintang untuk memberikan
                                                        rating</p>
                                                </div>

                                                {{-- Comment --}}
                                                <div>
                                                    <label for="comment-{{ $booking->id }}"
                                                        class="block text-sm font-medium text-gray-700 mb-2">
                                                        Komentar
                                                    </label>
                                                    <textarea name="comment" id="comment-{{ $booking->id }}" rows="4"
                                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                        placeholder="Bagikan pengalaman Anda dengan pelanggan ini (opsional)..." maxlength="500"></textarea>
                                                    <p class="mt-1 text-xs text-gray-500">Maksimal 500 karakter</p>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- Modal Footer --}}
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="button" onclick="submitReview('{{ $booking->id }}')"
                                                id="submit-btn-{{ $booking->id }}"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
                                                <span class="submit-text">Kirim Review</span>
                                                <span class="loading-text hidden">
                                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                    Mengirim...
                                                </span>
                                            </button>
                                            <button type="button" onclick="closeReviewModal('{{ $booking->id }}')"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

                {{-- Vehicle Reviews Section --}}
                <div class="bg-white p-8 rounded-2xl shadow-xl mt-12 border border-gray-200 max-w-7xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Rating & Ulasan Kendaraan</h3>

                    {{-- Vehicle Ratings Summary --}}
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Ringkasan Rating Kendaraan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($vehicleRatings as $vehicle)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h5 class="font-medium text-gray-900">{{ $vehicle->name }}</h5>
                                            <p class="text-sm text-gray-500">{{ $vehicle->category }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center">
                                                <span
                                                    class="text-2xl font-bold text-gray-900">{{ number_format($vehicle->reviews_avg_rating, 1) }}</span>
                                                <span class="text-gray-500 ml-1">/5</span>
                                            </div>
                                            <p class="text-sm text-gray-500">{{ $vehicle->total_reviews }} ulasan</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($vehicle->reviews_avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-8">
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Belum ada ulasan</h4>
                                    <p class="text-gray-500">Kendaraan Anda belum menerima ulasan dari pelanggan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Detailed Reviews List --}}
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Daftar Ulasan Terbaru</h4>
                        <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kendaraan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pelanggan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rating</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ulasan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($vehicleReviews as $review)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $review->vehicle->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $review->vehicle->category }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                                        <span
                                                            class="text-indigo-600 font-medium text-sm">{{ substr($review->user->name ?? 'U', 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $review->user->name ?? '-' }}</div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $review->user->email ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                    <span
                                                        class="ml-1 text-sm text-gray-500">({{ $review->rating }}/5)</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-md">
                                                    {{ Str::limit($review->comment, 100) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $review->created_at->format('d M Y') }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $review->created_at->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button onclick="openFlagModal('{{ $review->id }}')"
                                                    class="text-red-600 hover:text-red-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                    <p class="font-semibold text-lg text-gray-700">Belum Ada Ulasan</p>
                                                    <p class="text-sm">Kendaraan Anda belum menerima ulasan dari pelanggan.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Flag Review Modal --}}
                <div id="flag-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
                    role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form id="flag-form" action="{{ route('rental.reviews.flag') }}" method="POST">
                                @csrf
                                <input type="hidden" name="review_id" id="flag-review-id">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div
                                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Laporkan Ulasan
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    Berikan alasan mengapa ulasan ini perlu ditinjau ulang oleh tim
                                                    moderasi.
                                                </p>
                                            </div>
                                            <div class="mt-4">
                                                <label for="flag-reason"
                                                    class="block text-sm font-medium text-gray-700">Alasan</label>
                                                <select name="reason" id="flag-reason"
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                    <option value="spam">Spam atau konten tidak relevan</option>
                                                    <option value="inappropriate">Konten tidak pantas</option>
                                                    <option value="fake">Ulasan palsu</option>
                                                    <option value="other">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="mt-4">
                                                <label for="flag-details"
                                                    class="block text-sm font-medium text-gray-700">Detail Tambahan</label>
                                                <textarea name="details" id="flag-details" rows="3"
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Laporkan
                                    </button>
                                    <button type="button" onclick="closeFlagModal()"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Initialize star ratings
                        initializeStarRatings();

                        // Add form validation
                        addFormValidation();

                        // Add keyboard support for modals
                        addKeyboardSupport();
                    });

                    function initializeStarRatings() {
                        document.querySelectorAll('.star-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const rating = parseInt(this.getAttribute('data-rating'));
                                const bookingId = this.getAttribute('data-booking');
                                const container = document.getElementById(`star-rating-${bookingId}`);
                                const hiddenInput = document.getElementById(`rating-${bookingId}`);

                                // Update hidden input
                                hiddenInput.value = rating;

                                // Update star colors
                                container.querySelectorAll('.star-btn').forEach((star, index) => {
                                    if (index < rating) {
                                        star.classList.remove('text-gray-300');
                                        star.classList.add('text-yellow-400');
                                    } else {
                                        star.classList.remove('text-yellow-400');
                                        star.classList.add('text-gray-300');
                                    }
                                });
                            });

                            // Add hover effects
                            button.addEventListener('mouseenter', function() {
                                const rating = parseInt(this.getAttribute('data-rating'));
                                const bookingId = this.getAttribute('data-booking');
                                const container = document.getElementById(`star-rating-${bookingId}`);

                                container.querySelectorAll('.star-btn').forEach((star, index) => {
                                    if (index < rating) {
                                        star.classList.add('text-yellow-300');
                                    }
                                });
                            });

                            button.addEventListener('mouseleave', function() {
                                const bookingId = this.getAttribute('data-booking');
                                const container = document.getElementById(`star-rating-${bookingId}`);
                                const currentRating = document.getElementById(`rating-${bookingId}`).value;

                                container.querySelectorAll('.star-btn').forEach((star, index) => {
                                    star.classList.remove('text-yellow-300');
                                    if (currentRating && index < parseInt(currentRating)) {
                                        star.classList.remove('text-gray-300');
                                        star.classList.add('text-yellow-400');
                                    } else {
                                        star.classList.remove('text-yellow-400');
                                        star.classList.add('text-gray-300');
                                    }
                                });
                            });
                        });
                    }

                    function openReviewModal(bookingId) {
                        const modal = document.getElementById(`review-modal-${bookingId}`);
                        if (modal) {
                            modal.classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                            document.body.style.position = 'fixed';
                            document.body.style.width = '100%';

                            // Focus on the first star for accessibility
                            const firstStar = modal.querySelector('.star-btn');
                            if (firstStar) {
                                setTimeout(() => firstStar.focus(), 100);
                            }
                        }
                    }

                    function closeReviewModal(bookingId) {
                        const modal = document.getElementById(`review-modal-${bookingId}`);
                        if (modal) {
                            modal.classList.add('hidden');
                            document.body.style.overflow = '';
                            document.body.style.position = '';
                            document.body.style.width = '';

                            // Reset form
                            const form = document.getElementById(`review-form-${bookingId}`);
                            if (form) {
                                form.reset();
                                // Reset stars
                                const container = document.getElementById(`star-rating-${bookingId}`);
                                container.querySelectorAll('.star-btn').forEach(star => {
                                    star.classList.remove('text-yellow-400');
                                    star.classList.add('text-gray-300');
                                });
                                document.getElementById(`rating-${bookingId}`).value = '';
                            }
                        }
                    }

                    function submitReview(bookingId) {
                        const form = document.getElementById(`review-form-${bookingId}`);
                        const submitBtn = document.getElementById(`submit-btn-${bookingId}`);
                        const rating = document.getElementById(`rating-${bookingId}`).value;

                        if (!rating) {
                            alert('Silakan berikan rating terlebih dahulu.');
                            return;
                        }

                        // Show loading state
                        submitBtn.disabled = true;
                        submitBtn.querySelector('.submit-text').classList.add('hidden');
                        submitBtn.querySelector('.loading-text').classList.remove('hidden');

                        // Submit form
                        form.submit();
                    }

                    function addFormValidation() {
                        document.querySelectorAll('form[id^="review-form-"]').forEach(form => {
                            form.addEventListener('submit', function(e) {
                                const bookingId = this.id.replace('review-form-', '');
                                const rating = document.getElementById(`rating-${bookingId}`).value;

                                if (!rating) {
                                    e.preventDefault();
                                    alert('Silakan berikan rating terlebih dahulu.');
                                    return false;
                                }
                            });
                        });
                    }

                    function addKeyboardSupport() {
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                const openModals = document.querySelectorAll('[id^="review-modal-"]:not(.hidden)');
                                openModals.forEach(modal => {
                                    const bookingId = modal.id.replace('review-modal-', '');
                                    closeReviewModal(bookingId);
                                });
                            }
                        });
                    }

                    function openFlagModal(reviewId) {
                        document.getElementById('flag-review-id').value = reviewId;
                        document.getElementById('flag-modal').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeFlagModal() {
                        document.getElementById('flag-modal').classList.add('hidden');
                        document.body.style.overflow = '';
                        document.getElementById('flag-form').reset();
                    }

                    // Close modal when clicking outside
                    document.getElementById('flag-modal').addEventListener('click', function(e) {
                        if (e.target === this) {
                            closeFlagModal();
                        }
                    });

                    // Close modal with Escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closeFlagModal();
                        }
                    });
                </script>
            @endsection
