@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <!-- Header Section -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Manajemen Pemesanan</h2>
            <p class="text-gray-600">Kelola dan pantau semua pemesanan kendaraan dari pelanggan</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-2">
                <span class="text-sm text-gray-500">Total Pemesanan:</span>
                <span class="font-bold text-gray-900 ml-2">{{ $bookings->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Table Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
            <div class="grid grid-cols-12 gap-4 font-semibold text-gray-700 text-sm uppercase tracking-wide">
                <div class="col-span-2">Kendaraan</div>
                <div class="col-span-2">Pelanggan</div>
                <div class="col-span-3">Periode Sewa</div>
                <div class="col-span-2">Total Harga</div>
                <div class="col-span-2">Status</div>
                <div class="col-span-1 text-center">Aksi</div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-100">
            @forelse($bookings as $booking)
            <div class="grid grid-cols-12 gap-4 px-6 py-5 hover:bg-gray-50 transition-colors duration-200">
                <!-- Vehicle Info -->
                <div class="col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-900 truncate">{{ $booking->vehicle->name ?? '-' }}</div>
                            <div class="text-sm text-gray-500 truncate">{{ $booking->vehicle->category ?? '' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-semibold text-sm">
                                {{ strtoupper(substr($booking->user->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-900 truncate">{{ $booking->user->name ?? '-' }}</div>
                            <div class="text-sm text-gray-500 truncate">{{ $booking->user->email ?? '' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Period -->
                <div class="col-span-3 flex items-center">
                    <div class="bg-gray-50 rounded-lg p-3 w-full">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">Mulai</div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-8 border-t border-gray-300"></div>
                                <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                <div class="w-8 border-t border-gray-300"></div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price -->
                <div class="col-span-2 flex items-center">
                    <div class="bg-green-50 rounded-lg p-3 w-full">
                        <div class="font-bold text-green-800 text-lg">
                            Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-green-600">Total Pembayaran</div>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-span-2 flex items-center">
                    @php
                        $statusConfig = [
                            'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                            'berlangsung' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'dot' => 'bg-blue-500'],
                            'dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'dot' => 'bg-red-500'],
                            'menunggu' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                            'pending' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'border' => 'border-orange-200', 'dot' => 'bg-orange-500']
                        ];
                        $config = $statusConfig[$booking->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'dot' => 'bg-gray-500'];
                    @endphp
                    <div class="w-full">
                        <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold border w-full justify-center {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                            <span class="w-2 h-2 rounded-full mr-2 {{ $config['dot'] }}"></span>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="col-span-1 flex items-center justify-center">
                    <div class="flex space-x-2">
                        <a href="{{ route('rental.bookings.show', $booking->id) }}" 
                           class="inline-flex items-center p-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 group"
                           title="Lihat Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Enhanced Empty State -->
            <div class="px-6 py-20 text-center">
                <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum Ada Pemesanan</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Saat ini belum ada pemesanan kendaraan dari pelanggan. Pemesanan baru akan muncul di sini.
                </p>
                <div class="flex items-center justify-center space-x-4">
                    <a href="{{ route('vehicles.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Kelola Kendaraan
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection