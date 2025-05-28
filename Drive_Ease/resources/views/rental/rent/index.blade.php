<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Penyewaan Anda</h1>
        </div>
    </x-slot>

    <div class="py-8"> {{-- Hapus px-4 md:px-8 karena sudah diatur oleh max-w-7xl --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Tambahkan sm:px-6 lg:px-8 untuk padding konsisten --}}
            <div class="space-y-6">
                @forelse ($rents as $rent)
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden transform transition duration-300 hover:shadow-lg hover:scale-[1.01]"> {{-- Perbarui styling card --}}
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row gap-8">
                                <div class="w-full lg:w-64 h-48 lg:h-40 flex-shrink-0"> {{-- Tambahkan flex-shrink-0 --}}
                                    <img src="{{ $rent->car->image_url ?? 'https://placehold.co/300x200?text=No+Image' }}" {{-- Tambahkan teks placeholder --}}
                                        alt="{{ $rent->car->name }}" class="w-full h-full object-cover rounded-lg">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col gap-4"> {{-- Kurangi gap menjadi gap-4 --}}
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-start gap-3"> {{-- Kurangi gap --}}
                                            <h2 class="text-xl font-bold text-gray-900">{{ $rent->car->name }}</h2>
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                                @if ($rent->status === 'menunggu') bg-yellow-100 text-yellow-800
                                                @elseif($rent->status === 'konfirmasi') bg-green-100 text-green-800
                                                @elseif($rent->status === 'tolak') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif"> {{-- Tambahkan default styling --}}
                                                {{ ucfirst($rent->status) }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-gray-700"> {{-- Sesuaikan gap dan warna teks --}}
                                            <div>
                                                <p class="text-sm text-gray-500 mb-1">Tanggal Mulai</p>
                                                <p class="text-base font-medium">{{ \Carbon\Carbon::parse($rent->start_date)->format('d M Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 mb-1">Tanggal Selesai</p>
                                                <p class="text-base font-medium">{{ \Carbon\Carbon::parse($rent->end_date)->format('d M Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 mb-1">Total Biaya</p>
                                                <p class="text-lg font-bold text-green-700">Rp {{ number_format($rent->total_price, 0, ',', '.') }}</p> {{-- Warna lebih gelap --}}
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 mb-1">Penyewa</p>
                                                <p class="text-base font-medium text-blue-600">{{ $rent->customer->name }}</p> {{-- Beri highlight pada nama penyewa --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 lg:mt-0 flex flex-col items-stretch justify-center lg:justify-end"> {{-- Atur layout tombol --}}
                                    <a href="{{ route('rental.rents.show', $rent->id) }}"
                                        class="w-full lg:w-40 inline-flex items-center justify-center px-4 py-2.5 rounded-lg
                                        bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                        transition ease-in-out duration-150">
                                        <span>Lihat Detail</span>
                                        <svg class="ml-2 w-5 h-5 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg text-blue-800"> {{-- Ubah warna alert menjadi biru --}}
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20"> {{-- Ubah warna ikon --}}
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-base text-blue-700">
                                    Belum ada data penyewaan yang tersedia untuk rental Anda saat ini.
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>