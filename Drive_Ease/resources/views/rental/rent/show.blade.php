{{-- Reminder --}}
@php
    $now = \Carbon\Carbon::now();
    $startDate = \Carbon\Carbon::parse($rent->start_date);
    $diffInHours = $now->diffInHours($startDate, false);
    $lastChangeDate = $startDate->copy()->subDay();
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Detail Sewa</h2>
        </div>
    </x-slot>

    <div class="py-10 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('rental.rents.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg 
                    text-sm font-medium text-gray-700 hover:bg-gray-50 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                    transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Sewa
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1">
                            <div class="aspect-w-16 aspect-h-12">
                                <img src="{{ $rent->car->image_url ?? 'https://placehold.co/600x450/E2E8F0/94A3B8?text=Gambar+Mobil' }}"
                                    alt="{{ $rent->car->name }}"
                                    class="w-full h-full object-cover rounded-lg shadow-md">
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-6">
                            <div class="pb-4 border-b border-gray-200">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $rent->car->name }}</h1>
                                <span
                                    class="mt-2 inline-flex px-3 py-1.5 rounded-full text-xs font-semibold tracking-wide
                                    @if ($rent->status === 'menunggu') bg-yellow-100 text-yellow-800
                                    @elseif($rent->status === 'konfirmasi') bg-green-100 text-green-800
                                    @elseif($rent->status === 'batal') bg-red-100 text-red-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($rent->status) }}
                                </span>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 space-y-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <h3 class="text-xl font-semibold text-gray-800">Informasi Penyewa</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                                        <p class="text-base font-medium text-gray-700">{{ $rent->customer->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="text-base font-medium text-gray-700">{{ $rent->customer->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 space-y-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <h3 class="text-xl font-semibold text-gray-800">Detail Penyewaan</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Mulai</p>
                                        <p class="text-base font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($rent->start_date)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Selesai</p>
                                        <p class="text-base font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($rent->end_date)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Durasi</p>
                                        <p class="text-base font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($rent->start_date)->diffInDays($rent->end_date) }} hari
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Total Biaya</p>
                                        <p class="text-2xl font-bold text-green-700">
                                            Rp {{ number_format($rent->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 space-y-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                                     <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <h3 class="text-xl font-semibold text-gray-800">Spesifikasi Kendaraan</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Merek</p>
                                        <p class="text-base font-medium text-gray-700">{{ $rent->car->brand }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Model</p>
                                        <p class="text-base font-medium text-gray-700">{{ $rent->car->model }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tahun</p>
                                        <p class="text-base font-medium text-gray-700">{{ $rent->car->year }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Plat Nomor</p>
                                        <p class="text-base font-medium text-gray-700">{{ $rent->car->license_plate }}</p>
                                    </div>
                                </div>
                            </div>

                            @if (!empty($rent->side_note))
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md shadow-sm">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-semibold text-blue-700">Catatan Tambahan:</h4>
                                            <p class="text-sm text-blue-600">{{ $rent->side_note }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md shadow-sm">
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <div>
                                        <p class="font-semibold text-yellow-800">Perhatian:</p>
                                        <p class="text-sm">Penyewaan tidak dapat diubah dalam waktu 24 jam sebelum tanggal mulai.</p>
                                        <p class="mt-1 text-xs">Batas terakhir perubahan: 
                                            <span class="font-semibold">{{ $lastChangeDate->translatedFormat('d M Y, H:i') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if ($diffInHours >= 24)
                                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                    @if ($rent->status === 'menunggu')
                                        <button type="button"
                                            class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-green-600 rounded-lg font-semibold 
                                            text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                            focus:ring-green-500 transition-all duration-200 text-sm shadow hover:shadow-md"
                                            data-bs-toggle="modal" data-bs-target="#confirmRentModal">
                                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Konfirmasi Sewa
                                        </button>
                                    @endif
                                    @if ($rent->status !== 'batal')
                                        <button type="button"
                                            class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-red-600 rounded-lg font-semibold 
                                            text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                            focus:ring-red-500 transition-all duration-200 text-sm shadow hover:shadow-md"
                                            data-bs-toggle="modal" data-bs-target="#rejectRentModal">
                                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
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

    <div class="modal fade" id="confirmRentModal" tabindex="-1" aria-labelledby="confirmRentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white">
                <div class="modal-header border-b border-gray-200">
                    <h5 class="modal-title text-lg font-medium text-gray-900" id="confirmRentModalLabel">Konfirmasi Penyewaan</h5>
                    <button type="button" class="btn-close text-gray-400 hover:text-gray-600" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rental.rents.confirm', $rent->id) }}" method="POST">
                    @csrf
                    <div class="modal-body text-gray-700">
                        <p>Apakah Anda yakin ingin mengkonfirmasi penyewaan ini?</p>
                        <div class="mt-4">
                            <label for="side_note_confirm" class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                            <textarea name="side_note" id="side_note_confirm" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900 placeholder-gray-400"
                                placeholder="Tulis catatan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-t border-gray-200">
                        <button type="button" class="btn btn-light border border-gray-300 hover:bg-gray-100" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success bg-green-600 hover:bg-green-700">Ya, Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectRentModal" tabindex="-1" aria-labelledby="rejectRentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white">
                <div class="modal-header border-b border-gray-200">
                    <h5 class="modal-title text-lg font-medium text-gray-900" id="rejectRentModalLabel">Konfirmasi Pembatalan</h5>
                    <button type="button" class="btn-close text-gray-400 hover:text-gray-600" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rental.rents.reject', $rent->id) }}" method="POST">
                    @csrf
                    <div class="modal-body text-gray-700">
                        <p>Apakah Anda yakin ingin membatalkan penyewaan ini?</p>
                        <div class="mt-4">
                            <label for="side_note_reject" class="block text-sm font-medium text-gray-700 mb-1">Alasan Pembatalan (opsional)</label>
                            <textarea name="side_note" id="side_note_reject" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900 placeholder-gray-400"
                                placeholder="Tulis alasan pembatalan atau catatan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-t border-gray-200">
                        <button type="button" class="btn btn-light border border-gray-300 hover:bg-gray-100" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger bg-red-600 hover:bg-red-700">Ya, Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    @push('scripts')
    {{-- Alpine.js untuk notifikasi (opsional, jika belum ada global) --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
    @endpush

</x-app-layout>