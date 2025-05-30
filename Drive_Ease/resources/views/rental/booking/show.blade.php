@extends('layouts.app')

{{-- Reminder & Date Setup --}}
@php
    $now = \Carbon\Carbon::now();
    // Menggunakan $booking sebagai variabel utama
    $startDate = \Carbon\Carbon::parse($booking->start_date);
    $diffInHours = $now->diffInHours($startDate, false);
    // Batas terakhir untuk perubahan/keputusan adalah H-1 dari tanggal mulai
    $lastChangeDate = $startDate->copy()->subDay();
@endphp

@section('content')
    <div class="py-10 px-4 md:px-8  text-gray-900">
        <div class="max-w-7xl mx-auto ">
            <div class="mb-6">
                <a href="{{ route('rental.bookings.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 rounded-lg border border-gray-300 
                           text-sm font-medium text-gray-700 hover:bg-gray-200 
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
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <div class="lg:col-span-1">
                            <div class="aspect-w-16 aspect-h-12 min-h-40 rounded-lg shadow-md">
                                <img src="{{ $booking->vehicle->image_url ?? ($booking->vehicle->image_path ?? 'https://placehold.co/600x450/f3f4f6/6b7280?text=Gambar+Kendaraan') }}"
                                    alt="{{ $booking->vehicle->name }}" class="w-full h-full object-cover ">
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-6">

                            <div class="pb-4 border-b border-gray-200">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $booking->vehicle->name }}</h1>
                                <span
                                    class="mt-2 inline-flex px-3 py-1.5 rounded-full text-xs font-semibold tracking-wide
                                    @if ($booking->status === 'menunggu') bg-yellow-500 text-white
                                    @elseif($booking->status === 'konfirmasi') bg-blue-500 text-white
                                    @elseif($booking->status === 'berjalan') bg-green-500 text-white
                                    @elseif($booking->status === 'selesai') bg-gray-500 text-white
                                    @elseif($booking->status === 'batal') bg-red-500 text-white @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            <div class=" rounded-lg p-6 border border-gray-200 space-y-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <h3 class="text-xl font-semibold text-gray-900">Informasi Penyewa</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama Lengkap</p>
                                        <p class="text-base font-medium text-gray-900">{{ ucfirst($booking->user->name) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="text-base font-medium text-gray-900">{{ $booking->user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 space-y-4">
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
                                            {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Selesai</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Durasi</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                                            hari
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Total Biaya</p>
                                        <p class="text-2xl font-bold text-green-600">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 space-y-4">
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
                                    @if (isset($booking->vehicle->brand))
                                        <div>
                                            <p class="text-sm text-gray-600">Merek</p>
                                            <p class="text-base font-medium text-gray-900">{{ $booking->vehicle->brand }}
                                            </p>
                                        </div>
                                    @endif
                                    @if (isset($booking->vehicle->model))
                                        <div>
                                            <p class="text-sm text-gray-600">Model</p>
                                            <p class="text-base font-medium text-gray-900">{{ $booking->vehicle->model }}
                                            </p>
                                        </div>
                                    @endif
                                    @if (isset($booking->vehicle->name) && !isset($booking->vehicle->model))
                                        <div>
                                            <p class="text-sm text-gray-600">Nama/Model</p>
                                            <p class="text-base font-medium text-gray-900">{{ $booking->vehicle->name }}
                                            </p>
                                        </div>
                                    @endif
                                    @if (isset($booking->vehicle->year))
                                        <div>
                                            <p class="text-sm text-gray-600">Tahun</p>
                                            <p class="text-base font-medium text-gray-900">{{ $booking->vehicle->year }}
                                            </p>
                                        </div>
                                    @endif
                                    @if (isset($booking->vehicle->license_plate))
                                        <div>
                                            <p class="text-sm text-gray-600">Plat Nomor</p>
                                            <p class="text-base font-medium text-gray-900">
                                                {{ $booking->vehicle->license_plate }}</p>
                                        </div>
                                    @endif
                                    @if (isset($booking->vehicle->category))
                                        <div>
                                            <p class="text-sm text-gray-600">Kategori</p>
                                            <p class="text-base font-medium text-gray-900">
                                                {{ $booking->vehicle->category }}</p>
                                        </div>
                                    @endif
                                    @if (isset($booking->vehicle->location))
                                        <div>
                                            <p class="text-sm text-gray-600">Lokasi</p>
                                            <p class="text-base font-medium text-gray-900">
                                                {{ $booking->vehicle->location }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($booking->driver_id && isset($booking->driver))
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 space-y-4">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <h3 class="text-xl font-semibold text-gray-900">Informasi Driver</h3>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div>
                                            <img src="{{ $booking->driver->image_url ?? 'https://placehold.co/100x100/f3f4f6/6b7280?text=' . substr($booking->driver->name, 0, 1) }}"
                                                alt="Driver Image" class="w-20 h-20 rounded-lg object-cover shadow-md">
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-base font-medium text-gray-900">{{ $booking->driver->name }}</p>
                                            @if (isset($booking->driver->phone))
                                                <p class="text-sm text-gray-700">{{ $booking->driver->phone }}</p>
                                            @endif
                                            @if (isset($booking->driver->email))
                                                <p class="text-sm text-gray-700">{{ $booking->driver->email }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($booking->side_note))
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md shadow-sm">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-blue-600 mt-0.5 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-semibold text-blue-800">Catatan Tambahan:</h4>
                                            <p class="text-sm text-blue-700">{{ $booking->side_note }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="bg-yellow-50 border border-gray-200 text-yellow-800 p-4 rounded-md shadow-sm">
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-yellow-600 mt-0.5 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-yellow-900">Perhatian:</p>
                                        <p class="text-sm">Penyewaan tidak dapat diubah dalam waktu 24 jam sebelum tanggal
                                            mulai.</p>
                                        <p class="mt-1 text-xs">Batas terakhir perubahan:
                                            <span
                                                class="font-semibold">{{ $lastChangeDate->translatedFormat('d M Y, H:i') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if ($diffInHours >= 24)
                                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                    @if ($booking->status === 'menunggu')
                                        <button type="button"
                                            class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-green-600 rounded-lg font-semibold 
                                                   text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                   focus:ring-green-500 transition-all duration-200 text-sm shadow hover:shadow-md"
                                            data-bs-toggle="modal" data-bs-target="#confirmBookingModal">
                                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Konfirmasi Sewa
                                        </button>
                                    @endif

                                    @if ($booking->status !== 'batal' && $booking->status !== 'selesai')
                                        <button type="button"
                                            class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-red-600 rounded-lg font-semibold 
                                                   text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                   focus:ring-red-500 transition-all duration-200 text-sm shadow hover:shadow-md"
                                            data-bs-toggle="modal" data-bs-target="#cancelBookingModal">
                                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Batalkan Sewa
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    <div class="modal fade" id="confirmBookingModal" tabindex="-1" aria-labelledby="confirmBookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white text-gray-900">
                <div class="modal-header border-b border-gray-200">
                    <h5 class="modal-title text-lg font-medium" id="confirmBookingModalLabel">Konfirmasi Penyewaan</h5>
                    <button type="button" class="btn-close text-gray-600 hover:text-gray-700" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('rental.bookings.confirm', $booking->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin mengkonfirmasi penyewaan ini?</p>
                        <div class="mt-4">
                            <label for="side_note_confirm" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                                (opsional)</label>
                            <textarea name="side_note" id="side_note_confirm" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900 placeholder-gray-500"
                                placeholder="Tulis catatan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-t border-gray-200">
                        <button type="button"
                            class="btn btn-secondary bg-gray-200 hover:bg-gray-300 text-gray-700 border-gray-300"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success bg-green-600 hover:bg-green-700 text-white">Ya,
                            Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white text-gray-900">
                <div class="modal-header border-b border-gray-200">
                    <h5 class="modal-title text-lg font-medium" id="cancelBookingModalLabel">Konfirmasi Pembatalan</h5>
                    <button type="button" class="btn-close text-gray-600 hover:text-gray-700" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('rental.bookings.reject', $booking->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin membatalkan penyewaan ini?</p>
                        <div class="mt-4">
                            <label for="side_note_cancel" class="block text-sm font-medium text-gray-700 mb-1">Alasan
                                Pembatalan (opsional)</label>
                            <textarea name="side_note" id="side_note_cancel" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900 placeholder-gray-500"
                                placeholder="Tulis alasan pembatalan atau catatan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-t border-gray-200">
                        <button type="button"
                            class="btn btn-secondary bg-gray-200 hover:bg-gray-300 text-gray-700 border-gray-300"
                            data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger bg-red-600 hover:bg-red-700 text-white">Ya,
                            Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Session Notifications --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
            class="fixed bottom-4 right-4 z-50">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
            class="fixed bottom-4 right-4 z-50">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

@endsection

@push('scripts')
@endpush
