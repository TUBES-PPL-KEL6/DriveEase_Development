<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Sewa</h2>
        </div>
    </x-slot>

    <div class="py-10 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('user.rents.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white rounded-lg border border-gray-300 
                    text-sm font-medium text-gray-700 hover:bg-gray-50 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                    transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Riwayat Sewa
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-8 gap-y-6">
                        <div class="lg:col-span-1 space-y-6">
                            <div class="aspect-w-16 aspect-h-12">
                                <img src="{{ $rent->car->image_url ?? 'https://placehold.co/600x450/E2E8F0/94A3B8?text=Gambar+Mobil' }}"
                                    alt="{{ $rent->car->name }}"
                                    class="w-full h-full object-cover rounded-lg shadow-md">
                            </div>

                            <div>
                                <div
                                    class="w-full text-center p-3 rounded-lg border
                                    @if ($rent->status === 'menunggu') bg-yellow-50 text-yellow-800 border-yellow-300
                                    @elseif($rent->status === 'konfirmasi') bg-green-50 text-green-800 border-green-300
                                    @elseif($rent->status === 'berjalan') bg-blue-50 text-blue-800 border-blue-300
                                    @elseif($rent->status === 'selesai') bg-gray-100 text-gray-700 border-gray-300
                                    @elseif($rent->status === 'batal' || $rent->status === 'tolak') bg-red-50 text-red-800 border-red-300
                                    @else bg-gray-50 text-gray-800 border-gray-300 @endif">
                                    <span class="text-sm font-medium">Status:</span>
                                    <span class="ml-1.5 rtl:mr-1.5 rtl:ml-0 font-semibold text-sm">
                                        @if ($rent->status === 'menunggu') Menunggu Konfirmasi
                                        @elseif ($rent->status === 'konfirmasi') Terkonfirmasi
                                        @elseif ($rent->status === 'berjalan') Sedang Berjalan
                                        @elseif ($rent->status === 'selesai') Selesai
                                        @elseif ($rent->status === 'batal') Dibatalkan oleh Anda
                                        @elseif ($rent->status === 'tolak') Ditolak oleh Rental
                                        @else {{ ucfirst($rent->status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $startDateForAction = \Carbon\Carbon::parse($rent->start_date);
                                    $diffInHoursForAction = $now->diffInHours($startDateForAction, false);
                                @endphp

                                @if (($rent->status === 'menunggu' || $rent->status === 'konfirmasi') && $diffInHoursForAction >= 24)
                                    <button type="button"
                                        class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150"
                                        data-bs-toggle="modal" data-bs-target="#cancelRentModal">
                                        <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Batalkan Sewa
                                    </button>
                                @endif
                                {{-- User tidak bisa re-confirm, ini biasanya aksi dari sisi rental. 
                                     Jika user ingin mengubah, prosesnya mungkin beda (misal request perubahan)
                                @if ($rent->status === 'batal' && $diffInHoursForAction >= 24) 
                                    <button type="button"
                                        class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150"
                                        data-bs-toggle="modal" data-bs-target="#editRentModal">
                                        <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Ajukan Perubahan
                                    </button>
                                @endif
                                --}}
                                @if ($rent->status === 'selesai' && !$rent->review)
                                     <a href="{{ route('reviews.create', ['rent_id' => $rent->id, 'car_id' => $rent->car_id]) }}" {{-- Asumsi route --}}
                                        class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition duration-150">
                                        <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        Tulis Ulasan
                                    </a>
                                @elseif ($rent->status === 'selesai' && $rent->review)
                                     <a href="{{ route('reviews.edit', $rent->review->id) }}" {{-- Asumsi route --}}
                                        class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                        <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit Ulasan Anda
                                    </a>
                                @endif
                            </div>

                            @if (!empty($rent->side_note))
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md shadow-sm">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                        </svg>
                                        <div class="text-sm">
                                            <strong class="font-semibold text-blue-700">Catatan dari Rental:</strong>
                                            <p class="text-blue-600">{{ $rent->side_note }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-2 space-y-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-1">{{ $rent->car->name }}</h1>
                                <p class="text-sm text-gray-500">{{ $rent->car->brand }} &bull; {{ $rent->car->model }} &bull; Tahun {{ $rent->car->year }}</p>
                                <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ $rent->car->description ?? 'Deskripsi mobil tidak tersedia.' }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Detail Penyewaan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Tanggal Mulai</p>
                                        <p class="text-sm font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($rent->start_date)->translatedFormat('l, d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Tanggal Selesai</p>
                                        <p class="text-sm font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($rent->end_date)->translatedFormat('l, d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Durasi Sewa</p>
                                        <p class="text-sm font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($rent->start_date)->diffInDays($rent->end_date) }} hari
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Total Biaya</p>
                                        <p class="text-lg font-bold text-green-600">
                                            Rp {{ number_format($rent->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Penyedia Jasa Rental</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Nama Rental / Pemilik</p>
                                        <p class="text-sm font-medium text-gray-700">{{ $rent->car->owner->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Email Kontak</p>
                                        <p class="text-sm font-medium text-gray-700">{{ $rent->car->owner->email ?? 'N/A' }}</p>
                                    </div>
                                    {{-- Bisa ditambahkan No. Telp jika ada --}}
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Kendaraan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Kategori</p>
                                        <p class="text-sm font-medium text-gray-700">{{ $rent->car->category }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Lokasi Jemput</p>
                                        <p class="text-sm font-medium text-gray-700">{{ $rent->car->location }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Plat Nomor</p>
                                        <p class="text-sm font-medium text-gray-700">{{ $rent->car->license_plate }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            @php
                                // Variabel sudah didefinisikan di atas untuk Action Buttons, bisa dipakai lagi
                                $lastChangeDate = \Carbon\Carbon::parse($rent->start_date)->copy()->subDay();
                            @endphp
                            @if ($diffInHoursForAction >= 0) {{-- Tampilkan hanya jika sewa belum dimulai / belum lewat jauh --}}
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-md shadow-sm">
                                <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <div>
                                        <p class="font-semibold text-yellow-800">Ketentuan Perubahan & Pembatalan:</p>
                                        <p class="text-sm">Perubahan atau pembatalan sewa tidak dapat dilakukan kurang dari 24 jam sebelum tanggal mulai sewa.</p>
                                        <p class="mt-1 text-xs">Batas terakhir perubahan/pembatalan: 
                                            <span class="font-semibold">{{ $lastChangeDate->translatedFormat('l, d M Y \p\u\k\u\l H:i') }}</span>
                                        </p>
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

    {{-- Modals (Hanya aktifkan jika tombol pemicunya ada dan kondisi terpenuhi) --}}
    @if (($rent->status === 'menunggu' || $rent->status === 'konfirmasi') && $diffInHoursForAction >= 24)
        <div class="modal fade" id="cancelRentModal" tabindex="-1" aria-labelledby="cancelRentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-white">
                    <div class="modal-header border-b border-gray-200">
                        <h5 class="modal-title text-lg font-medium text-gray-900" id="cancelRentModalLabel">Konfirmasi Pembatalan Sewa</h5>
                        <button type="button" class="btn-close text-gray-400 hover:text-gray-600" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.rents.reject', $rent->id) }}" method="POST">
                        @csrf
                        <div class="modal-body text-gray-700">
                            <p>Apakah Anda yakin ingin membatalkan penyewaan untuk mobil <strong class="text-gray-800">{{ $rent->car->name }}</strong>?</p>
                            <p class="text-xs text-gray-500 mt-1">Pembatalan ini tidak dapat diurungkan.</p>
                            <div class="mt-4">
                                <label for="cancel_side_note" class="block text-sm font-medium text-gray-700 mb-1">Alasan Pembatalan (opsional)</label>
                                <textarea name="side_note" id="cancel_side_note" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm bg-white text-gray-900 placeholder-gray-400"
                                    placeholder="Berikan alasan Anda..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-gray-50 border-t border-gray-200">
                            <button type="button" class="btn btn-light border border-gray-300 hover:bg-gray-100 shadow-sm" data-bs-dismiss="modal">Tidak, Kembali</button>
                            <button type="submit" class="btn btn-danger bg-red-600 hover:bg-red-700 text-white shadow-sm">Ya, Batalkan Sewa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Edit/Re-confirm: Logika ini mungkin perlu penyesuaian tergantung alur bisnis Anda.
         Biasanya user tidak "re-confirm" booking yang dibatalkan, tapi membuat booking baru atau request perubahan.
         Kode di bawah ini adalah contoh jika Anda memang punya fitur re-confirm/edit dari sisi user.
    --}}
    @if ($rent->status === 'batal' && $diffInHoursForAction >= 24 && false) {{-- Dinonaktifkan sementara --}}
        <div class="modal fade" id="editRentModal" tabindex="-1" aria-labelledby="editRentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-white">
                    <div class="modal-header border-b border-gray-200">
                        <h5 class="modal-title text-lg font-medium text-gray-900" id="editRentModalLabel">Ajukan Perubahan Sewa</h5>
                        <button type="button" class="btn-close text-gray-400 hover:text-gray-600" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.rents.reConfirm', $rent->id) }}" method="POST"> {{-- Sesuaikan route jika perlu --}}
                        @csrf
                        <div class="modal-body space-y-4 text-gray-700">
                            <div>
                                <label for="edit_car_id" class="block text-sm font-medium text-gray-700 mb-1">Mobil</label>
                                <select name="car_id" id="edit_car_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm bg-white text-gray-900" required>
                                    @php 
                                        // Sebaiknya $availableCars dikirim dari controller
                                        $availableCars = \App\Models\Car::where('available', true)->get(); 
                                    @endphp
                                    @foreach ($availableCars as $car)
                                        <option value="{{ $car->id }}" @if ($car->id == $rent->car_id) selected @endif>
                                            {{ $car->name }} (Rp {{ number_format($car->price_per_day,0,',','.') }}/hari)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai Baru</label>
                                    <input type="date" name="start_date" id="edit_start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm bg-white text-gray-900" value="{{ \Carbon\Carbon::parse($rent->start_date)->format('Y-m-d') }}" required>
                                </div>
                                <div>
                                    <label for="edit_end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Baru</label>
                                    <input type="date" name="end_date" id="edit_end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm bg-white text-gray-900" value="{{ \Carbon\Carbon::parse($rent->end_date)->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div>
                                <label for="edit_side_note" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (opsional)</label>
                                <textarea name="side_note" id="edit_side_note" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm bg-white text-gray-900 placeholder-gray-400" placeholder="Misal: Permintaan khusus...">{{ $rent->side_note }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-gray-50 border-t border-gray-200">
                            <button type="button" class="btn btn-light border border-gray-300 hover:bg-gray-100 shadow-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white shadow-sm">Ajukan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
            class="fixed bottom-4 right-4 z-50 p-4 rounded-md bg-green-500 text-white shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
         <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
            class="fixed bottom-4 right-4 z-50 p-4 rounded-md bg-red-500 text-white shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @push('scripts')
    {{-- Jika menggunakan AlpineJS untuk notifikasi, pastikan sudah di-load --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
    @endpush

</x-app-layout>