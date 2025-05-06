<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Detail Sewa</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('rental.rents.index') }}"
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
                                <img src="https://placehold.co/400x300" alt="{{ $rent->car->name }}"
                                    class="w-full h-full object-cover rounded-lg shadow-md">
                            </div>
                        </div>

                        <!-- Rental Details Section -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Header with Status -->
                            <div class="space-y-4">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $rent->car->name }}</h1>
                                <span
                                    class="inline-flex px-4 py-2 rounded-full text-sm font-medium
                                    @if ($rent->status === 'menunggu') bg-yellow-100 text-yellow-800
                                    @elseif($rent->status === 'konfirmasi') bg-green-100 text-green-800
                                    @elseif($rent->status === 'tolak') bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($rent->status) }}
                                </span>
                            </div>

<<<<<<< Updated upstream
                            <!-- Customer Info -->
                            <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Penyewa</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                                        <p class="text-base font-medium text-gray-900">{{ $rent->customer->name }}</p>
=======
                        @if ($diffInHours >= 24)
                            <div class="flex flex-col gap-2 mt-2">
                                @if ($rent->status === 'menunggu')
                                    <button type="button" dusk="konfirmasi-sewa-button"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-green-600 rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition"
                                        data-bs-toggle="modal" data-bs-target="#confirmRentModal">
                                        Konfirmasi Sewa
                                    </button>
                                @endif
                                @if ($rent->status !== 'batal')
                                    <button type="button" dusk="batalkan-sewa-button"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-red-600 rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition"
                                        data-bs-toggle="modal" data-bs-target="#rejectRentModal">
                                        Batalkan Sewa
                                    </button>
                                @endif
                            </div>
                        @endif

                        <!-- Confirm Modal -->
                        <div class="modal fade" id="confirmRentModal" tabindex="-1"
                            aria-labelledby="confirmRentModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmRentModalLabel">Konfirmasi Penyewaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
>>>>>>> Stashed changes
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="text-base font-medium text-gray-900">{{ $rent->customer->email }}</p>
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
                                            {{ \Carbon\Carbon::parse($rent->start_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Tanggal Selesai</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($rent->end_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Durasi</p>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($rent->start_date)->diffInDays($rent->end_date) }}
                                            hari
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-500">Total Biaya</p>
                                        <p class="text-xl font-semibold text-green-600">
                                            Rp {{ number_format($rent->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            @if ($rent->status === 'menunggu')
                                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                    <form action="{{ route('rental.rents.confirm', $rent->id) }}" method="POST"
                                        class="flex-1">
                                        @csrf
<<<<<<< Updated upstream
                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg
                                            bg-green-600 text-white font-medium hover:bg-green-700 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 
                                            transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Konfirmasi Sewa
                                        </button>
=======
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin mengkonfirmasi penyewaan ini?</p>
                                            <div class="mb-3 mt-4">
                                                <label for="side_note_confirm"
                                                    class="block text-sm font-medium text-gray-700">Catatan
                                                    (opsional)</label>
                                                <textarea name="side_note" id="side_note_confirm" rows="3"
                                                    class="form-control border text-dark w-full rounded-md mt-1" placeholder="Tulis catatan tambahan..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success" dusk="konfirmasi-sewa-confirm-button">Ya, Konfirmasi</button> 
                                        </div>
>>>>>>> Stashed changes
                                    </form>

                                    <form action="{{ route('rental.rents.reject', $rent->id) }}" method="POST"
                                        class="flex-1">
                                        @csrf
<<<<<<< Updated upstream
                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg
                                            bg-red-600 text-white font-medium hover:bg-red-700 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 
                                            transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Tolak Sewa
                                        </button>
=======
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menolak penyewaan ini?</p>
                                            <div class="mb-3 mt-4">
                                                <label for="side_note_reject"
                                                    class="block text-sm font-medium text-gray-700">Catatan
                                                    (opsional)</label>
                                                <textarea name="side_note" id="side_note_reject" rows="3"
                                                    class="form-control border text-dark w-full rounded-md mt-1" dusk="side-note-reject"
                                                    placeholder="Tulis alasan penolakan atau catatan tambahan..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal" dusk="batalkan-sewa-cancel-button">Batal</button> 
                                            <button type="submit" class="btn btn-danger" dusk="batalkan-sewa-confirm-button">Ya, Batalkan</button>
                                        </div>
>>>>>>> Stashed changes
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if (session('success'))
        <div class="fixed bottom-4 right-4 z-50">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-4 right-4 z-50">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif
</x-app-layout>
