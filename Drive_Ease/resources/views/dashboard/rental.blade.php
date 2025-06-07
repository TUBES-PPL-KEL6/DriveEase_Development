@extends('layouts.app')

@section('styles')
    <style>
        table, th, td { border: none !important; }
        table { border-collapse: collapse; }
        thead th {
            color: #334155 !important;
        }
        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        tbody tr:hover {
            background-color: #eff6ff;
        }
    </style>
@endsection

@section('content')
<h2 class="font-semibold text-2xl leading-tight text-gray-800 mb-6">Dashboard Pemilik Rental</h2>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700 text-lg mb-4">
                Selamat datang, <span class="font-bold text-blue-600">{{ auth()->user()->name }}</span>!
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 mb-8">
                <div class="bg-blue-50 p-4 rounded-lg shadow-sm border border-blue-200">
                    <p class="text-sm text-gray-600 mb-1">Total Pemesanan</p>
                    <h2 class="text-3xl font-bold text-blue-800">{{ $totalBookings }}</h2>
                </div>
                <div class="bg-green-50 p-4 rounded-lg shadow-sm border border-green-200">
                    <p class="text-sm text-gray-600 mb-1">Total Pendapatan</p>
                    <h2 class="text-3xl font-bold text-green-700">Rp{{ number_format($totalRevenue) }}</h2>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg shadow-sm border border-purple-200">
                    <p class="text-sm text-gray-600 mb-1">Jumlah Kendaraan Disewakan</p>
                    <h2 class="text-3xl font-bold text-purple-700">{{ auth()->user()->vehicles->count() }}</h2>
                </div>
            </div>

            {{-- Grafik Penghasilan Bulanan --}}
            <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-xl shadow-md p-6 border border-blue-100 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-blue-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3v18h18M9 17V9m4 8V5m4 12v-6" />
                        </svg>
                        Grafik Penghasilan Bulanan
                    </h2>
                    <span class="inline-block bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-semibold">
                        {{ now()->year }}
                    </span>
                </div>
                <div class="h-72 relative">
                    <canvas id="revenueChart"></canvas>
                    <div id="revenueChartEmpty" class="absolute inset-0 flex flex-col items-center justify-center text-blue-400 bg-white bg-opacity-80 rounded-xl"
                        style="display: none;">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="font-semibold text-lg">Belum Ada Data Penghasilan</p>
                        <p class="text-sm">Transaksi selesai akan tampil di sini dalam bentuk grafik.</p>
                    </div>
                </div>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mt-6 mb-4">Top 5 Kendaraan Paling Banyak Disewa</h3>
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg border border-gray-200">
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full w-full text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Kendaraan</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Jumlah Disewa</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200 text-slate-700">
                            @forelse($mostRentedVehicles as $vehicle)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-900">{{ $vehicle->name }}</div>
                                        {{-- <div class="text-xs text-slate-500">{{ $vehicle->category ?? 'N/A' }}</div> --}}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <span class="font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">
                                            {{ $vehicle->bookings_count }}x
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-10 text-center text-slate-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <p class="font-semibold text-lg text-slate-700">Belum Ada Data</p>
                                            <p class="text-sm">Saat ini belum ada data penyewaan kendaraan yang tercatat.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="my-8 border-gray-200">

            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Kendaraan Anda</h3>
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg border border-gray-200">
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full w-full text-sm">
                        <thead class="bg-blue-50 text-blue-700">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Kendaraan</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Lokasi</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Harga/Hari</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                            @forelse(auth()->user()->vehicles as $vehicle)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $vehicle->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $vehicle->category ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $vehicle->location }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-800 font-medium">
                                        Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($vehicle->available)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Tidak Tersedia
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex justify-center items-center space-x-2 rtl:space-x-reverse">
                                            <a href="{{ route('rental.vehicles.edit', $vehicle->id) }}"
                                               class="inline-flex items-center justify-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('rental.vehicles.destroy', $vehicle->id) }}" method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan {{ $vehicle->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                    <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="font-semibold text-lg">Belum Ada Kendaraan</p>
                                            <p class="text-sm">Anda belum menambahkan kendaraan apapun ke daftar rental Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('rental.vehicles.create') }}"
                   class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 text-center font-semibold shadow-md">
                    + Tambah Kendaraan
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('rental.drivers.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Kelola Driver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const labels = {!! json_encode($labels) !!};
    const data = {!! json_encode($data) !!};

    // Deteksi jika semua data nol
    const isAllZero = data.every(val => val === 0);
    if (isAllZero) {
        document.getElementById('revenueChart').style.opacity = 0.2;
        document.getElementById('revenueChartEmpty').style.display = 'flex';
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                backgroundColor: data.map(val => val === 0 ? 'rgba(203,213,225,0.5)' : 'rgba(59,130,246,0.7)'),
                borderColor: data.map(val => val === 0 ? 'rgba(203,213,225,1)' : 'rgb(59,130,246)'),
                borderWidth: 2,
                borderRadius: 8,
                maxBarThickness: 40,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#e0e7ef' },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush