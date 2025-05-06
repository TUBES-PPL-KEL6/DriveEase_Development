<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Sewa</h1>
        </div>
    </x-slot>

    <div class="py-8 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="space-y-6">
                @forelse ($rents as $rent)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
<<<<<<< HEAD
<<<<<<< HEAD
                        <div class="p-4">
=======
                        <div class="p-6">
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
                            <div class="flex flex-col lg:flex-row gap-8">
                                <!-- Car Image -->
                                <div class="w-full lg:w-64 h-48 lg:h-40">
                                    <img src="{{ $rent->car->image_url ?? 'https://placehold.co/300x200' }}"
                                        alt="{{ $rent->car->name }}" class="w-full h-full object-cover rounded-lg">
<<<<<<< HEAD
=======
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row gap-8">
                                <!-- Car Image -->
                                <div class="w-full lg:w-64 h-48 lg:h-40">
                                    <img src="https://placehold.co/300x200" alt="{{ $rent->car->name }}"
                                        class="w-full h-full object-cover rounded-lg">
>>>>>>> main
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
                                </div>

                                <!-- Rental Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col gap-6">
                                        <!-- Header -->
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-start gap-4">
                                            <h2 class="text-xl font-bold text-gray-900">{{ $rent->car->name }}</h2>
                                            <span class="inline-flex px-4 py-1.5 rounded-full text-sm font-medium
                                                @if ($rent->status === 'menunggu') bg-yellow-100 text-yellow-800
                                                @elseif($rent->status === 'konfirmasi') bg-green-100 text-green-800
                                                @elseif($rent->status === 'tolak') bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($rent->status) }}
                                            </span>
                                        </div>

                                        <!-- Details Grid -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-500">Tanggal Mulai</p>
                                                <p class="text-base font-medium">
                                                    {{ \Carbon\Carbon::parse($rent->start_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-500">Tanggal Selesai</p>
                                                <p class="text-base font-medium">
                                                    {{ \Carbon\Carbon::parse($rent->end_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-500">Total Biaya</p>
                                                <p class="text-lg font-semibold text-green-600">
                                                    Rp {{ number_format($rent->total_price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-500">Penyewa</p>
                                                <p class="text-base font-medium">{{ $rent->customer->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-6 lg:mt-0 flex lg:flex-col justify-end">
<<<<<<< HEAD
<<<<<<< HEAD
                                    <a href="{{ route('rents.show', $rent->id) }}"
=======
<<<<<<< Updated upstream
                                    <a href="{{ route('rental.rents.show', $rent->id) }}"
=======
                                    <a href="{{ route('rents.show', $rent->id) }}" dusk="lihat-detail-button"
>>>>>>> Stashed changes
>>>>>>> main
=======
                                    <a href="{{ route('rental.rents.show', $rent->id) }}"
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
                                        class="w-full lg:w-40 inline-flex items-center justify-center p-2 rounded-lg
                                        bg-blue-600 text-white font-medium hover:bg-blue-700 
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                        transition-all duration-200">
                                        <span>Lihat Detail</span>
                                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor"
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
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-base text-yellow-700">
                                    Belum ada data sewa yang tersedia
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
