@extends('layouts.app')

@php
    // Mendefinisikan variabel waktu di awal untuk digunakan di beberapa tempat
    $now = \Carbon\Carbon::now();
    $startDateForAction = \Carbon\Carbon::parse($booking->start_date);
    $diffInHoursForAction = $now->diffInHours($startDateForAction, false); // false: bisa negatif jika sudah lewat
    $lastChangeDate = $startDateForAction->copy()->subDay();
    // Get the review for this vehicle by the current user
    $userReview = \App\Models\Review::where('user_id', auth()->id())
        ->where('vehicle_id', $booking->vehicle_id)
        ->first();
@endphp

@section('content')
    <div class="py-10 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('user.bookings.mine') }}" {{-- Menggunakan route standar booking --}}
                    class="inline-flex items-center px-4 py-2 bg-white rounded-lg border border-gray-300 
                           text-sm font-medium text-gray-700 hover:bg-gray-50 
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                           transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-8 gap-y-6">
                        {{-- Kolom Kiri: Gambar, Status, Aksi, Catatan --}}
                        <div class="lg:col-span-1 space-y-6">
                            <div class="aspect-w-16 aspect-h-12 rounded-lg shadow-md min-h-40">
                                <img src="{{ $booking->vehicle->image_path ? asset('storage/' . $booking->vehicle->image_path) : 'https://placehold.co/600x450/E2E8F0/94A3B8?text=Gambar+' . urlencode($booking->vehicle->name) }}"
                                    alt="{{ $booking->vehicle->name }}" class="w-full h-full object-cover ">
                            </div>

                            <div>
                                <div
                                    class="w-full text-center p-3 rounded-lg border
                                    @if ($booking->status === 'menunggu pembayaran') bg-yellow-500 text-white
                                    @elseif($booking->status === 'menunggu konfirmasi') bg-gray-500 text-white
                                    @elseif($booking->status === 'konfirmasi') bg-blue-500 text-white
                                    @elseif($booking->status === 'berjalan') bg-green-500 text-white
                                    @elseif($booking->status === 'selesai') bg-gray-500 text-white
                                    @elseif($booking->status === 'batal') bg-red-500 text-white @endif">
                                    <span class="text-sm font-medium">Status:</span>
                                    <span class="ml-1.5 rtl:mr-1.5 rtl:ml-0 font-semibold text-sm">
                                        @if ($booking->status === 'menunggu')
                                            Menunggu Konfirmasi
                                        @elseif ($booking->status === 'konfirmasi')
                                            Terkonfirmasi
                                        @elseif ($booking->status === 'berjalan')
                                            Sedang Berjalan
                                        @elseif ($booking->status === 'selesai')
                                            Selesai
                                        @elseif ($booking->status === 'batal')
                                            Dibatalkan
                                        @else
                                            {{ ucfirst($booking->status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @if ($diffInHoursForAction >= 0)
                                    <div
                                        class="bg-yellow-50 border border-gray-200 text-yellow-800 p-4 rounded-lg shadow-sm">
                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                            <div>
                                                <p class="font-semibold text-yellow-800">Ketentuan:
                                                </p>
                                                <p class="text-sm">Perubahan atau pembatalan pemesanan tidak dapat
                                                    dilakukan
                                                    kurang dari 24 jam sebelum tanggal mulai sewa.</p>
                                                <p class="mt-1 text-xs">Batas terakhir perubahan/pembatalan:
                                                    <br>
                                                    <span
                                                        class="font-semibold">{{ $lastChangeDate->translatedFormat('l, d M Y H:i') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (($booking->status === 'menunggu' || $booking->status === 'konfirmasi') && $diffInHoursForAction >= 24)
                                    <button type="button"
                                        class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150"
                                        data-bs-toggle="modal" data-bs-target="#cancelBookingModal">
                                        <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Batalkan Pemesanan
                                    </button>
                                @endif

                                {{-- Tombol untuk Tulis/Edit Ulasan --}}
                                @if ($booking->status === 'selesai')
                                    @if (!$userReview)
                                        <a href="{{ route('reviews.create', ['booking_id' => $booking->id, 'vehicle_id' => $booking->vehicle_id]) }}"
                                            class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition duration-150">
                                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                            Tulis Ulasan
                                        </a>
                                    @else
                                        <a href="{{ route('reviews.edit', $userReview->id) }}"
                                            class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Edit Ulasan Anda
                                        </a>
                                    @endif
                                @endif

                                {{-- Tombol "Ajukan Perubahan" jika statusnya sudah 'konfirmasi' (jika > 24 jam) --}}

                                @if ($booking->status === 'konfirmasi' && $diffInHoursForAction >= 24)
                                    <button type="button"
                                        class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150"
                                        data-bs-toggle="modal" data-bs-target="#requestChangeModal">
                                        <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                            </path>
                                        </svg>
                                        Ajukan Perubahan
                                    </button>
                                @endif

                            </div>

                            @if (!empty($booking->side_note))
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md shadow-sm">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                        </svg>
                                        <div class="text-sm">
                                            <strong class="font-semibold text-blue-700">Catatan dari Penyedia:</strong>
                                            <p class="text-blue-600">{{ $booking->side_note }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Kolom Kanan: Detail Kendaraan, Sewa, Rental, Driver, Ketentuan --}}
                        <div class="lg:col-span-2 space-y-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-1">{{ $booking->vehicle->name }}</h1>
                                <p class="text-sm text-gray-500">
                                    {{ $booking->vehicle->brand ?? 'N/A' }} &bull;
                                    {{ $booking->vehicle->model ?? 'N/A' }} &bull;
                                    Tahun {{ $booking->vehicle->year ?? 'N/A' }}
                                </p>
                                <p class="mt-3 text-gray-600 text-sm leading-relaxed">
                                    {{ $booking->vehicle->description ?? 'Deskripsi mobil tidak tersedia.' }}
                                </p>
                            </div>

                            <div class="rounded-lg p-6 border border-gray-200 space-y-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h3 class="text-xl font-semibold text-gray-900">Detail Penyewaan</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Mulai</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('l, d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Selesai</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('l, d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Durasi Sewa</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                                            hari
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Total Biaya</p>
                                        <p class="text-base font-bold text-green-600">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg p-6 border border-gray-200 space-y-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z">
                                        </path>
                                    </svg>
                                    <h3 class="text-xl font-semibold text-gray-900">Informasi Rental</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama Penyedia</p>
                                        {{-- Asumsi relasi vehicle->rental atau vehicle->owner ada --}}
                                        <p class="text-base font-medium text-gray-900">
                                            {{ $booking->vehicle->rental->name ?? ($booking->vehicle->owner->name ?? 'N/A') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email Kontak</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ $booking->vehicle->rental->email ?? ($booking->vehicle->owner->email ?? 'N/A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg p-6 border border-gray-200 space-y-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10h14c1.1 0 2 .9 2 2v3c0 1.1-.9 2-2 2h-1l-1 3h-2l1-3H8l1 3H7l-1-3H5c-1.1 0-2-.9-2-2v-3c0-1.1.9-2 2-2zm0 0V7a2 2 0 012-2h10a2 2 0 012 2v3M7 14h10">
                                        </path>
                                    </svg>
                                    <h3 class="text-xl font-semibold text-gray-900">Kendaraan</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Kategori </p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ $booking->vehicle->category ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm
                                            text-gray-600">Lokasi
                                        </p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ $booking->vehicle->location ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Plat Nomor</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ $booking->vehicle->license_plate ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            @if ($booking->driver_id && $booking->driver)
                                <div class="rounded-lg p-6 border border-gray-200 space-y-4">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <h3 class="text-xl font-semibold text-gray-900">Informasi Driver</h3>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div>
                                            <img src="{{ $booking->driver->photo ? asset('storage/' . $booking->driver->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->driver->name) . '&background=EBF4FF&color=7F9CF5' }}"
                                                alt="Foto {{ $booking->driver->name }}"
                                                class="w-16 h-16 rounded-full object-cover shadow-sm">
                                        </div>
                                        <div class="text-sm space-y-1">
                                            <p class="text-base font-medium text-gray-900">{{ $booking->driver->name }}
                                            </p>
                                            @if ($booking->driver->phone_number)
                                                <p class="text-sm text-gray-600">Telp:
                                                    {{ $booking->driver->phone_number }}
                                                </p>
                                            @endif
                                            {{-- <p class="text-gray-500">{{ $booking->driver->email ?? '' }}</p> --}}
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pembatalan --}}
    @if (($booking->status === 'menunggu' || $booking->status === 'konfirmasi') && $diffInHoursForAction >= 24)
        <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-white">
                    <div class="modal-header border-b border-gray-200">
                        <h5 class="modal-title text-lg font-medium text-gray-900" id="cancelBookingModalLabel">
                            Konfirmasi
                            Pembatalan Pemesanan</h5>
                        <button type="button" class="btn-close text-gray-400 hover:text-gray-600"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST">
                        @csrf
                        <div class="modal-body text-gray-700">
                            <p>Apakah Anda yakin ingin membatalkan pemesanan untuk <strong
                                    class="text-gray-800">{{ $booking->vehicle->name }}</strong>?</p>
                            <p class="text-xs text-gray-500 mt-1">Pembatalan ini tidak dapat diurungkan setelah
                                dikonfirmasi.</p>
                            <div class="mt-4">
                                <label for="cancel_side_note" class="block text-sm font-medium text-gray-700 mb-1">Alasan
                                    Pembatalan (opsional)</label>
                                <textarea name="side_note" id="cancel_side_note" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm bg-white text-gray-900 placeholder-gray-400"
                                    placeholder="Berikan alasan Anda..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-gray-50 border-t border-gray-200">
                            <button type="button"
                                class="btn btn-light border border-gray-300 hover:bg-gray-100 shadow-sm"
                                data-bs-dismiss="modal">Tidak, Kembali</button>
                            <button type="submit"
                                class="btn btn-danger bg-red-600 hover:bg-red-700 text-white shadow-sm">Ya, Batalkan
                                Pemesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Ajukan Perubahan (Contoh, jika ingin diimplementasikan) --}}
    @if ($booking->status === 'konfirmasi' && $diffInHoursForAction >= 24)
        <div class="modal fade" id="requestChangeModal" tabindex="-1" aria-labelledby="requestChangeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-white">
                    <div class="modal-header border-b border-gray-200">
                        <h5 class="modal-title text-lg font-medium text-gray-900" id="requestChangeModalLabel">Ajukan
                            Perubahan Pemesanan</h5>
                        <button type="button" class="btn-close text-gray-400 hover:text-gray-600"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.bookings.reConfirm', $booking->id) }}" method="POST">
                        @csrf
                        <div class="modal-body space-y-4 text-gray-700">
                            <p>Anda dapat mengajukan perubahan untuk pemesanan ini. Perubahan akan memerlukan konfirmasi
                                ulang dari penyedia.</p>
                            <div>
                                <label for="edit_vehicle_id"
                                    class="block text-sm font-medium text-gray-700 mb-1">Kendaraan (jika ingin
                                    ganti)</label>
                                <select name="vehicle_id" id="edit_vehicle_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900">
                                    @php $availableVehicles = \App\Models\Vehicle::where('available', true)->get(); @endphp
                                    @foreach ($availableVehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                            @if ($vehicle->id == $booking->vehicle_id) selected @endif>
                                            {{ $vehicle->name }} (Rp
                                            {{ number_format($vehicle->price_per_day, 0, ',', '.') }}/hari)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_start_date"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai Baru</label>
                                    <input type="date" name="start_date" id="edit_start_date"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900"
                                        value="{{ \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') }}"
                                        required>
                                </div>
                                <div>
                                    <label for="edit_end_date"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Baru</label>
                                    <input type="date" name="end_date" id="edit_end_date"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900"
                                        value="{{ \Carbon\Carbon::parse($booking->end_date)->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div>
                                <label for="edit_side_note" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                                    Perubahan (opsional)</label>
                                <textarea name="side_note" id="edit_side_note" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900 placeholder-gray-400"
                                    placeholder="Alasan perubahan, permintaan khusus...">{{ $booking->side_note_user_request ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-gray-50 border-t border-gray-200">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary bg-blue-600 text-white">Ajukan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
            class="fixed bottom-4 right-4 z-50 p-4 rounded-md bg-green-500 text-white shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
            class="fixed bottom-4 right-4 z-50 p-4 rounded-md bg-red-500 text-white shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
@endsection

@push('scripts')
    {{-- Script untuk validasi tanggal pada modal edit/ajukan perubahan (jika diaktifkan) --}}
    <script>
        const editStartDateInput = document.getElementById('edit_start_date');
        const editEndDateInput = document.getElementById('edit_end_date');

        if (editStartDateInput && editEndDateInput) {
            const todayForEdit = "{{ now()->format('Y-m-d') }}";

            editStartDateInput.min = todayForEdit;

            function updateEditEndDateMin() {
                if (editStartDateInput.value) {
                    let nextDayOfStartDateEdit = new Date(editStartDateInput.value);
                    nextDayOfStartDateEdit.setDate(nextDayOfStartDateEdit.getDate() + 1); // Selesai minimal H+1 dari mulai
                    const minEndDateEdit = nextDayOfStartDateEdit.toISOString().split('T')[0];

                    editEndDateInput.min = minEndDateEdit;
                    if (editEndDateInput.value && editEndDateInput.value < minEndDateEdit) {
                        editEndDateInput.value = minEndDateEdit;
                    }
                } else {
                    // Jika tanggal mulai kosong, set min tanggal selesai ke besok dari hari ini
                    let tomorrowForEdit = new Date(todayForEdit);
                    tomorrowForEdit.setDate(tomorrowForEdit.getDate() + 1);
                    editEndDateInput.min = tomorrowForEdit.toISOString().split('T')[0];
                }
            }

            editStartDateInput.addEventListener('change', updateEditEndDateMin);
            // Panggil sekali saat load untuk set end_date.min jika start_date sudah ada value
            if (editStartDateInput.value) {
                updateEditEndDateMin();
            } else {
                // Jika tanggal mulai kosong, set min tanggal selesai ke besok dari hari ini
                let tomorrowForEdit = new Date(todayForEdit);
                tomorrowForEdit.setDate(tomorrowForEdit.getDate() + 1);
                if (editEndDateInput) editEndDateInput.min = tomorrowForEdit.toISOString().split('T')[0];
            }
        }
    </script>
@endpush
