@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Pemesanan</h2>
        <p class="text-gray-600">Kelola dan pantau semua pemesanan kendaraan Anda</p>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Table Header -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
            <div class="grid grid-cols-12 gap-4 font-semibold text-gray-700 text-sm uppercase tracking-wide">
                <div class="col-span-3">Kendaraan</div>
                <div class="col-span-3">Periode Sewa</div>
                <div class="col-span-2">Total Harga</div>
                <div class="col-span-2">Status</div>
                <div class="col-span-2 text-center">Aksi</div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-100">
            @forelse($bookings as $booking)
            <div class="grid grid-cols-12 gap-4 px-6 py-5 hover:bg-gray-50 transition-colors duration-200">
                <!-- Vehicle Info -->
                <div class="col-span-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $booking->vehicle->name ?? '-' }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->vehicle->category ?? '' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Period -->
                <div class="col-span-3 flex items-center">
                    <div>
                        <div class="text-sm text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-500 flex items-center mt-1">
                            <span>sampai</span>
                            <svg class="w-3 h-3 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <!-- Price -->
                <div class="col-span-2 flex items-center">
                    <div class="font-bold text-gray-900">
                        Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Status -->
                <div class="col-span-2 flex items-center">
                    @php
                        $statusClasses = [
                            'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'berlangsung' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'dibatalkan' => 'bg-red-100 text-red-800 border-red-200',
                            'menunggu' => 'bg-amber-100 text-amber-800 border-amber-200'
                        ];
                        $statusClass = $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClass }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 
                            {{ $booking->status === 'selesai' ? 'bg-emerald-500' : 
                               ($booking->status === 'berlangsung' ? 'bg-blue-500' : 
                               ($booking->status === 'dibatalkan' ? 'bg-red-500' : 'bg-amber-500')) }}">
                        </span>
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

                <!-- Actions -->
                <div class="col-span-2 flex items-center justify-center">
                    <a href="{{ route('user.bookings.show', $booking->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Detail
                    </a>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="px-6 py-16 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pemesanan</h3>
                <p class="text-gray-600 mb-6">Anda belum memiliki riwayat pemesanan kendaraan.</p>
                <a href="{{ route('vehicles.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Mulai Pesan Sekarang
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection