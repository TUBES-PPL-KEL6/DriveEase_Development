@extends('layouts.app')

@section('content')
    <div class="py-8 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <a href="{{ route('rental.dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-dark rounded-lg border border-gray-600 
               text-sm font-medium text-gray-300 hover:bg-gray-800 
               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
               transition-all duration-200 me-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-100">Daftar Driver</h1>
                </div>
                <a href="{{ route('rental.drivers.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-lg text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Driver
                </a>
            </div>

            <div class="bg-dark rounded-xl shadow-sm border border-gray-700">
                <div class="p-6">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full table-auto divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-800 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Foto</th>
                                    <th
                                        class="px-6 py-3 bg-gray-800 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 bg-gray-800 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Telepon</th>
                                    <th
                                        class="px-6 py-3 bg-gray-800 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 bg-gray-800 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-dark divide-y divide-gray-700">
                                @forelse ($drivers as $driver)
                                    <tr>
                                        <td class="px-2 py-4 whitespace-nowrap">
                                            <img src="{{ $driver->photo ? asset($driver->photo) : 'https://placehold.co/400x400?text=' . substr($driver->name, 0, 1) }}"
                                                alt="{{ $driver->name }}" class="h-12 w-12 rounded-full object-cover">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-100">{{ $driver->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-100">{{ $driver->phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-100">{{ $driver->email ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('rental.drivers.show', $driver->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-900 text-blue-200 rounded-lg hover:bg-blue-800 transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Detail
                                                </a>
                                                <a href="{{ route('rental.drivers.edit', $driver->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-yellow-900 text-yellow-200 rounded-lg hover:bg-yellow-800 transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('rental.drivers.destroy', $driver->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus driver ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-900 text-red-200 rounded-lg hover:bg-red-800 transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-400">
                                            Belum ada data driver
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($drivers->hasPages())
                        <div class="mt-4">
                            {{ $drivers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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
@endsection
