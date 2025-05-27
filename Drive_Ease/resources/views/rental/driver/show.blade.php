@extends('layouts.app')

@section('content')
    <div class="py-8 px-4 md:px-8">
        <div class="max-w-3xl mx-auto space-y-4">
            <div class="mb-6">
                <a href="{{ route('rental.drivers.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white rounded-lg border border-gray-300 
               text-sm font-medium text-gray-700 hover:bg-gray-50 
               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
               transition-all duration-200 me-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detail Driver</h2>
                        <div class="flex gap-3">
                            <a href="{{ route('rental.drivers.edit', $driver) }}"
                                class="inline-flex items-center px-4 py-2 bg-yellow-100 rounded-lg font-medium border border-yellow-300 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('rental.drivers.destroy', $driver->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus driver ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 rounded-lg text-white font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Driver Photo -->
                        <div>
                            <img src="{{ $driver->photo ?? 'https://placehold.co/400x400?text=' . substr($driver->name, 0, 1) }}"
                                alt="{{ $driver->name }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                        </div>

                        <!-- Driver Info -->
                        <div class="space-y-6 col-span-3">
                            <div>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                                        <p class="text-base font-medium text-gray-900">{{ $driver->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                                        <p class="text-base font-medium text-gray-900">{{ $driver->phone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="text-base font-medium text-gray-900">{{ $driver->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Jadwal Tugas</h3>
                    <div class="mt-4 w-full">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full divide-y divide-gray-200 border border-gray-200 ">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kendaraan
                                        </th>
                                        <th
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Mulai
                                        </th>
                                        <th
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Selesai
                                        </th>
                                        <th
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class=" divide-y divide-gray-200">
                                    @forelse($driver->jobs as $job)
                                        <tr class="bg-ragy-50 hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $job->booking->vehicle->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($job->start_date)->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($job->end_date)->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center border border-gray-300 p-2 rounded-full text-xs font-medium
                                                    {{ match ($job->booking->status) {
                                                        'konfirmasi' => 'bg-green-100 text-green-800',
                                                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                        'selesai' => 'bg-blue-100 text-blue-800',
                                                        'batal' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    } }}">
                                                    {{ ucfirst($job->booking->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                                Belum ada jadwal tugas
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
