@extends('layouts.app')

{{-- Reminder --}}
@php
    $now = \Carbon\Carbon::now();
    $startDate = \Carbon\Carbon::parse($booking->start_date);
    $decisionDeadline = $startDate->copy()->subDay();
    $diffInHours = $now->diffInHours($startDate, false);
@endphp

@section('content')

    <div class="py-8 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('rental.bookings.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white rounded-lg border border-gray-300 
                    text-sm font-medium text-gray-700 hover:bg-gray-50 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                    transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Car Image Section -->
                        <div class="lg:col-span-1">
                            <div class="aspect-w-16 aspect-h-12">
                                <img src="{{ $booking->vehicle->image_path ?? 'https://placehold.co/400x300' }}"
                                    alt="{{ $booking->vehicle->name }}"
                                    class="w-full h-full object-cover rounded-lg shadow-md">
                            </div>
                        </div>

                        <!-- Rental Details Section -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Header with Status -->
                            <div class="space-y-4">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $booking->vehicle->name }}</h1>
                                <span
                                    class="inline-flex px-4 py-2 rounded-full text-sm font-medium
                                    @if ($booking->status === 'menunggu') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'konfirmasi') bg-green-100 text-green-800
                                    @elseif($booking->status === 'batal') bg-red-100 text-red-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            <!-- Customer Info -->
                            <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Penyewa</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                                        <p class="text-base font-medium text-gray-900">{{ ucfirst($booking->user->name) }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="text-base font-medium text-gray-900">{{ $booking->user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rental Details -->
                            <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-900">Detail Penyewaan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Tanggal Mulai</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Tanggal Selesai</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Durasi</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                                            hari
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Total Biaya</p>
                                        <p class="text-xl font-semibold text-green-600">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Details -->
                            <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-900">Spesifikasi Kendaraan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Nama</p>
                                        <p class="text-base font-medium text-gray-900">{{ $booking->vehicle->name }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Kategori</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ $booking->vehicle->category }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Lokasi</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ $booking->vehicle->location }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Driver Info --}}
                            @if ($booking->driver_id)
                                <div class=" bg-gray-100 rounded-xl p-4 space-y-2">
                                    <h3 class="text-lg font-semibold text-gray-900">Driver</h3>
                                    <div class="flex items-center gap-4">
                                        <div class="">
                                            <img src="https://placehold.co/400x300?text={{ $booking->driver->name }}"
                                                alt="Driver Image" class="w-20 h-20 rounded-lg object-cover shadow-md">
                                        </div>
                                        <span class="flex items-center">
                                            <svg class="inline-block w-5 h-5 mr-1 text-black" fill="black"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <p class="text-base font-medium">{{ $booking->driver->name }}</p>
                                        </span>
                                        <p class="text-base font-medium">{{ $booking->driver->phone }}</p>
                                        <p class="text-base font-medium">{{ $booking->driver->email }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Side Note Display -->
                            @if (!empty($booking->side_note))
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                        </svg>
                                        <span class="text-sm text-blue-900"><strong>Catatan:</strong>
                                            {{ $booking->side_note }}</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Deadline Warning -->
                            @php
                                $lastChangeDate = $startDate->copy()->subDay();
                            @endphp
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg">
                                <p class="font-semibold">Perhatian:</p>
                                <p>Penyewaan tidak dapat diubah dalam waktu 24 jam sebelum tanggal mulai.</p>
                                <p class="mt-1 text-sm">Batas terakhir untuk melakukan perubahan adalah: <span
                                        class="font-semibold">{{ $lastChangeDate->format('d M Y H:i') }}</span></p>
                            </div>

                            <!-- Action Buttons -->
                            @if ($diffInHours >= 24)
                                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                    @if ($booking->status === 'menunggu')
                                        <button type="button"
                                            class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-green-600 rounded-lg font-semibold 
                                        text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-green-500 transition-all duration-200"
                                            data-bs-toggle="modal" data-bs-target="#confirmRentModal">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Konfirmasi Sewa
                                        </button>
                                    @endif
                                    @if ($booking->status !== 'batal')
                                        <button type="button"
                                            class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-red-600 rounded-lg font-semibold 
                                        text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-red-500 transition-all duration-200"
                                            data-bs-toggle="modal" data-bs-target="#rejectRentModal">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
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

    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmRentModal" tabindex="-1" aria-labelledby="confirmRentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmRentModalLabel">Konfirmasi Penyewaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rental.bookings.confirm', $booking->id) }}" method="POST" class="d-inline">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin mengkonfirmasi penyewaan ini?</p>
                        <div class="mb-3 mt-4">
                            <label for="side_note_confirm" class="block text-sm font-medium text-gray-700">Catatan
                                (opsional)</label>
                            <textarea name="side_note" id="side_note_confirm" rows="3"
                                class="form-control border text-dark w-full rounded-md mt-1" placeholder="Tulis catatan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectRentModal" tabindex="-1" aria-labelledby="rejectRentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectRentModalLabel">Konfirmasi Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rental.bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak penyewaan ini?</p>
                        <div class="mb-3 mt-4">
                            <label for="side_note_reject" class="block text-sm font-medium text-gray-700">Catatan
                                (opsional)</label>
                            <textarea name="side_note" id="side_note_reject" rows="3"
                                class="form-control border text-dark w-full rounded-md mt-1"
                                placeholder="Tulis alasan penolakan atau catatan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if (session('success'))
        <div class="fixed bottom-4 right-4 z-50" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-4 right-4 z-50" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif
@endsection
