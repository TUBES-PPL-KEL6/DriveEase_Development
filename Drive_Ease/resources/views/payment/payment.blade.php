@extends('layouts.app')

@section('content')
    <div class="py-8 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('index') }}"
<<<<<<< Updated upstream
                    class="w-full lg:w-40 inline-flex items-center justify-center px-4 py-2.5 rounded-lg
                                        bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                        transition ease-in-out duration-150">
=======
                    class="inline-flex items-center px-4 py-2 bg-dark rounded-lg border border-gray-600 
                    text-sm font-medium text-gray-300 hover:bg-gray-800 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                    transition-all duration-200">
>>>>>>> Stashed changes
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>









<<<<<<< Updated upstream
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
=======
            <div class="bg-dark rounded-xl shadow-sm">
>>>>>>> Stashed changes
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Car Image Section -->
                        <div class="lg:col-span-1">
                            <div class="aspect-w-16 aspect-h-12">
                                <img src="https://placehold.co/400x300?text={{ $payment->vehicle->name }}"
                                    alt="{{ $payment->vehicle->name }}"
                                    class="w-full h-full object-cover rounded-lg shadow-md">
                            </div>

                            <!-- Status Badge - Prominent for customers -->
                            <div class="mt-4">
                                <div
                                    class="w-full text-center p-3 rounded-lg border border-gray-600
<<<<<<< Updated upstream
                                    @if ($payment->status === 'menunggu pembayaran') bg-yellow-900 text-yellow-200
                                    @elseif ($payment->status === 'menunggu konfirmasi') bg-dark text-gray-200
=======
                                    @if ($payment->status === 'menunggu') bg-yellow-900 text-yellow-200
>>>>>>> Stashed changes
                                    @elseif($payment->status === 'konfirmasi') bg-green-900 text-green-200
                                    @elseif($payment->status === 'berjalan') bg-blue-900 text-blue-200
                                    @elseif($payment->status === 'selesai') bg-gray-800 text-gray-200
                                    @elseif($payment->status === 'batal' || $payment->status === 'tolak') bg-red-900 text-red-200
<<<<<<< Updated upstream
                                    @else bg-dark text-gray-200 @endif">
=======
                                    @else bg-gray-800 text-gray-200 @endif">
>>>>>>> Stashed changes
                                    <span class="text-sm font-medium">Status:</span>
                                    <span class="ml-2 font-semibold">
                                        @if ($payment->status === 'menunggu')
                                            Menunggu Konfirmasi
                                        @elseif ($payment->status === 'konfirmasi')
                                            Terkonfirmasi
                                        @elseif ($payment->status === 'berjalan')
                                            Berjalan
                                        @elseif ($payment->status === 'selesai')
                                            Selesai
                                        @elseif ($payment->status === 'batal')
                                            Dibatalkan
                                        @elseif ($payment->status === 'tolak')
                                            Ditolak
                                        @else
                                            {{ ucfirst($payment->status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 space-y-3">
<<<<<<< Updated upstream
                                @if ($payment->status === 'menunggu pembayaran' || $payment->status === 'konfirmasi')
=======
                                @if ($payment->status === 'menunggu' || $payment->status === 'konfirmasi')
>>>>>>> Stashed changes
                                    <button type="button"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition"
                                        data-bs-toggle="modal" data-bs-target="#cancelRentModal">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Batalkan Sewa
                                    </button>
                                @endif
                                @if ($payment->status === 'batal')
                                    <button type="button"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
                                        data-bs-toggle="modal" data-bs-target="#editRentModal">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Konfirmasi Ulang
                                    </button>
                                @endif
                            </div>

                            <!-- Side Note -->
                            @if (!empty($payment->side_note))
                                <div class="mt-6 bg-blue-900 border-l-4 border-blue-400 p-4 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                        </svg>
                                        <span class="text-sm text-blue-200">
                                            <strong>Catatan:</strong> {{ $payment->side_note }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Rental Details Section -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Car Info -->
                            <div>
<<<<<<< Updated upstream
                                <h1 class="text-3xl font-bold mb-2">{{ $payment->vehicle->name }}</h1>
=======
                                <h1 class="text-3xl font-bold text-gray-100 mb-2">{{ $payment->vehicle->name }}</h1>
>>>>>>> Stashed changes
                                <p class="text-gray-400">{{ $payment->vehicle->description }}</p>
                            </div>

                            <!-- PaymentDetails -->
<<<<<<< Updated upstream
                            <div class="border border-dark bg-white rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold">Pembayaran</h3>
                                
                                
                                <!-- Include Snap.js Midtrans -->
                                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-O8tHu5YdW5g95-p5"></script>
                                
                                <!-- Tombol Bayar -->
                                @if ($payment->status === 'sudah dibayar')
                                <button disabled class="bg-gray-500 text-white px-4 py-2 rounded cursor-not-allowed">Sudah Dibayar</button>
                                @else
                                <button id="pay-button" class="w-full lg:w-100 inline-flex items-center justify-center px-4 py-2.5 rounded-lg
                                        bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                        transition ease-in-out duration-150">Bayar Sekarang</button>
                                <!-- Script JS Midtrans disini -->
                                @endif
                                
                                
                                
                                
                                <script type="text/javascript">
                                    document.getElementById('pay-button').addEventListener('click', function () {
                                        window.snap.pay('{{ $snapToken }}', {
                                            onSuccess: function(result){
                                                // Simpan hasil pembayaran ke server (opsional via AJAX)
                                                alert("Pembayaran Berhasil");
                                                window.location.href = "{{ route('user.dashboard.user') }}"; // arahkan ke home
                                            },
                                            onPending: function(result){
                                                alert("Menunggu Pembayaran");
                                            },
                                            onError: function(result){
                                                alert("Pembayaran Gagal");
                                            }
                                        });
                                    });
                                    </script>

                                    <div class="space-y-2">
                                            <p class="text-sm text-gray-400">Supported Payment</p>
                                            <p class="text-base font-medium">Gopay, ShopeePay, Bank Digital, dan lainnya.</p>
                                    </div>
=======
                            <div class="bg-gray-800 rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-100">Pembayaran</h3>




                                <!-- Include Snap.js Midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-O8tHu5YdW5g95-p5"></script>

<!-- Tombol Bayar -->
@if ($payment->status === 'sudah dibayar')
    <button disabled class="bg-gray-500 text-white px-4 py-2 rounded cursor-not-allowed">Sudah Dibayar</button>
@else
    <button id="pay-button" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Bayar Sekarang</button>
    <!-- Script JS Midtrans disini -->
@endif




<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                // Simpan hasil pembayaran ke server (opsional via AJAX)
                alert("Pembayaran Berhasil");
                window.location.href = "{{ route('user.dashboard.user') }}"; // arahkan ke home
            },
            onPending: function(result){
                alert("Menunggu Pembayaran");
            },
            onError: function(result){
                alert("Pembayaran Gagal");
            }
        });
    });
</script>
>>>>>>> Stashed changes




</div>
                            <!-- Rental Details -->
<<<<<<< Updated upstream
                            <div class="border border-dark bg-white rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold">Detail Penyewaan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Tanggal Mulai</p>
                                        <p class="text-base font-medium">
=======
                            <div class="bg-gray-800 rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-100">Detail Penyewaan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Tanggal Mulai</p>
                                        <p class="text-base font-medium text-gray-100">
>>>>>>> Stashed changes
                                            {{ \Carbon\Carbon::parse($payment->start_date)->format('l, d F Y') }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Tanggal Selesai</p>
<<<<<<< Updated upstream
                                        <p class="text-base font-medium">
=======
                                        <p class="text-base font-medium text-gray-100">
>>>>>>> Stashed changes
                                            {{ \Carbon\Carbon::parse($payment->end_date)->format('l, d F Y') }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Durasi</p>
<<<<<<< Updated upstream
                                        <p class="text-base font-medium">
=======
                                        <p class="text-base font-medium text-gray-100">
>>>>>>> Stashed changes
                                            {{ \Carbon\Carbon::parse($payment->start_date)->diffInDays($payment->end_date) }}
                                            hari</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Total Biaya</p>
                                        <p class="text-xl font-semibold text-green-400">
                                            Rp {{ number_format($payment->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rental Owner Info -->
<<<<<<< Updated upstream
                            <div class="border border-dark bg-white rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold">Informasi Rental</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Nama Rental</p>
                                        <p class="text-base font-medium">
=======
                            <div class="bg-gray-800 rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-100">Informasi Rental</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Nama Rental</p>
                                        <p class="text-base font-medium text-gray-100">
>>>>>>> Stashed changes
                                            {{ ucfirst($payment->vehicle->rental->name) }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Email</p>
<<<<<<< Updated upstream
                                        <p class="text-base font-medium">
=======
                                        <p class="text-base font-medium text-gray-100">
>>>>>>> Stashed changes
                                            {{ $payment->vehicle->rental->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Details -->
<<<<<<< Updated upstream
                            <div class="border border-dark bg-white rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold">Spesifikasi Kendaraan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Nama</p>
                                        <p class="text-base font-medium">{{ $payment->vehicle->name }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Kategori</p>
                                        <p class="text-base font-medium">{{ $payment->vehicle->category }}
=======
                            <div class="bg-gray-800 rounded-xl p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-100">Spesifikasi Kendaraan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Nama</p>
                                        <p class="text-base font-medium text-gray-100">{{ $payment->vehicle->name }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Kategori</p>
                                        <p class="text-base font-medium text-gray-100">{{ $payment->vehicle->category }}
>>>>>>> Stashed changes
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-400">Lokasi</p>
<<<<<<< Updated upstream
                                        <p class="text-base font-medium">{{ $payment->vehicle->location }}
=======
                                        <p class="text-base font-medium text-gray-100">{{ $payment->vehicle->location }}
>>>>>>> Stashed changes
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Driver --}}
                            @if ($payment->driver_id)
                                <div class="bg-gray-800 rounded-xl p-4 space-y-2">
                                    <h3 class="text-lg font-semibold text-gray-100">Driver</h3>
                                    <div class="flex items-center gap-4">
                                        <div class="">
                                            <img src="https://placehold.co/400x300?text={{ $payment->driver->name }}"
                                                alt="Driver Image" class="w-20 h-20 rounded-lg object-cover shadow-md">
                                        </div>
                                        <span class="flex items-center">
                                            <svg class="inline-block w-5 h-5 mr-1 text-gray-300" fill="currentColor"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <p class="text-base font-medium text-gray-100">{{ $payment->driver->name }}
                                            </p>
                                        </span>
                                        <p class="text-base font-medium text-gray-100">{{ $payment->driver->phone }}</p>
                                        <p class="text-base font-medium text-gray-100">{{ $payment->driver->email }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Rental Policy Notice -->
                            @php
                                $now = \Carbon\Carbon::now();
                                $startDate = \Carbon\Carbon::parse($payment->start_date);
                                $diffInHours = $now->diffInHours($startDate, false);
                                $lastChangeDate = $startDate->copy()->subDay();
                            @endphp
                            <div class="bg-yellow-900 border-l-4 border-yellow-500 text-yellow-200 p-4 rounded-lg">
                                <p class="font-semibold">Perhatian:</p>
                                <p>Penyewaan tidak dapat diubah dalam waktu 24 jam sebelum tanggal mulai.</p>
                                <p class="mt-1 text-sm">Batas terakhir untuk melakukan perubahan adalah:
                                    <span class="font-semibold">{{ $lastChangeDate->format('d M Y H:i') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
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
