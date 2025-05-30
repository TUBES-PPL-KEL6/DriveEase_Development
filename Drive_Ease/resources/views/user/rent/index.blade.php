<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Riwayat Sewa Anda</h1>
                <p class="mt-1 text-sm text-gray-600">Lihat semua transaksi penyewaan kendaraan yang pernah Anda lakukan.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="space-y-6">
                @forelse ($rents as $rent)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-200 transition-all duration-300 overflow-hidden">
                        <div class="p-5 md:p-6">
                            <div class="flex flex-col lg:flex-row gap-6">
                                <div class="w-full lg:w-56 h-48 lg:h-40 flex-shrink-0">
                                    <img src="{{ $rent->car->image_url ?? 'https://placehold.co/300x200/E2E8F0/94A3B8?text=Gambar+Mobil' }}"
                                        alt="{{ $rent->car->name }}" class="w-full h-full object-cover rounded-lg shadow-sm">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col gap-4">
                                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                            <div>
                                                <h2 class="text-xl font-bold text-gray-800 hover:text-blue-600 transition">
                                                    {{-- Jika ada halaman detail mobil khusus:
                                                    <a href="{{ route('cars.show', $rent->car->id) }}">{{ $rent->car->name }}</a> 
                                                    --}}
                                                    {{ $rent->car->name }}
                                                </h2>
                                                <p class="text-xs text-gray-500">{{ $rent->car->brand }} &bull; {{ $rent->car->model }}</p>
                                            </div>
                                            <span class="mt-1 sm:mt-0 inline-flex px-3 py-1 rounded-full text-xs font-semibold tracking-wide
                                                @if ($rent->status === 'menunggu') bg-yellow-100 text-yellow-800
                                                @elseif($rent->status === 'konfirmasi') bg-green-100 text-green-800
                                                @elseif($rent->status === 'berjalan') bg-blue-100 text-blue-800
                                                @elseif($rent->status === 'selesai') bg-gray-200 text-gray-700
                                                @elseif($rent->status === 'batal' || $rent->status === 'tolak') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($rent->status) }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                                            <div class="space-y-0.5">
                                                <p class="text-xs text-gray-500">Tanggal Mulai</p>
                                                <p class="text-sm font-medium text-gray-700">
                                                    {{ \Carbon\Carbon::parse($rent->start_date)->translatedFormat('d M Y') }}
                                                </p>
                                            </div>
                                            <div class="space-y-0.5">
                                                <p class="text-xs text-gray-500">Tanggal Selesai</p>
                                                <p class="text-sm font-medium text-gray-700">
                                                    {{ \Carbon\Carbon::parse($rent->end_date)->translatedFormat('d M Y') }}
                                                </p>
                                            </div>
                                            <div class="space-y-0.5">
                                                <p class="text-xs text-gray-500">Penyedia Jasa Rental</p>
                                                <p class="text-sm font-medium text-gray-700">{{ $rent->car->owner->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="space-y-0.5 sm:col-span-2 md:col-span-1">
                                                <p class="text-xs text-gray-500">Total Biaya</p>
                                                <p class="text-base font-semibold text-green-600">
                                                    Rp {{ number_format($rent->total_price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 lg:mt-0 flex lg:flex-col lg:items-end lg:justify-center lg:ml-auto flex-shrink-0">
                                    <a href="{{ route('user.rents.show', $rent->id) }}"
                                        class="w-full lg:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-lg
                                        bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                        transition-all duration-200 shadow-sm hover:shadow-md">
                                        <span>Lihat Detail</span>
                                        <svg class="ml-2 rtl:mr-2 rtl:ml-0 w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-7 w-7 text-blue-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-4 rtl:mr-4 rtl:ml-0">
                                <p class="text-base font-medium text-blue-700">
                                    Anda belum memiliki riwayat sewa.
                                </p>
                                <p class="text-sm text-blue-600 mt-1">
                                    Temukan dan sewa kendaraan impian Anda sekarang!
                                    {{-- <a href="{{ route('cars.index') }}" class="font-semibold hover:underline">Cari Kendaraan</a> --}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            @if ($rents->hasPages())
                <div class="mt-8">
                    {{ $rents->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>