@extends('layouts.app')

@section('content')
<div class="py-10 px-4 md:px-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 pb-4 border-b border-gray-200">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Kendaraan Rental Anda</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola daftar kendaraan yang Anda sewakan.</p>
            </div>
            <a href="{{ route('rental.vehicles.create') }}"
               class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2.5 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 mr-2 -ml-1 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Kendaraan
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('error'))
             <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                         <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif


        <div class="space-y-6">
            @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5 md:p-6">
                        <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                            <div class="w-full md:w-48 h-40 md:h-32 flex-shrink-0">
                                <img src="{{ $vehicle->image_path ? asset('storage/' . $vehicle->image_path) : 'https://placehold.co/300x200/E2E8F0/94A3B8?text=Gambar+Tidak+Ada' }}"
                                     alt="{{ $vehicle->name }}" class="w-full h-full object-cover rounded-lg shadow-sm">
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row justify-between sm:items-start mb-1">
                                    <h3 class="text-xl font-semibold text-gray-800 hover:text-blue-600 transition">
                                        {{-- Jika ada halaman show, bisa ditambahkan link di sini --}}
                                        {{-- <a href="{{ route('rental.vehicles.show', $vehicle->id) }}">{{ $vehicle->name }}</a> --}}
                                         {{ $vehicle->name }}
                                    </h3>
                                    @if($vehicle->available)
                                        <span class="mt-1 sm:mt-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="mt-1 sm:mt-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Tidak Tersedia
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500">{{ $vehicle->category }} &bull; {{ $vehicle->location }}</p>
                                <p class="text-lg font-bold text-green-700 mt-2">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}/hari</p>
                                @if($vehicle->description)
                                <p class="text-xs text-gray-600 mt-2 line-clamp-2" title="{{ $vehicle->description }}">
                                    {{ Str::limit($vehicle->description, 100) }}
                                </p>
                                @endif
                            </div>

                            <div class="mt-4 md:mt-0 flex flex-col sm:flex-row md:flex-col gap-2 items-stretch md:items-end justify-start md:justify-start md:w-auto flex-shrink-0">
                                <a href="{{ route('rental.vehicles.edit', $vehicle->id) }}"
                                   class="inline-flex items-center justify-center px-3.5 py-2 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-1.5 rtl:ml-1.5 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                <form action="{{ route('rental.vehicles.destroy', $vehicle->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan {{ $vehicle->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-3.5 py-2 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-1.5 rtl:ml-1.5 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg text-blue-800 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-7 w-7 text-blue-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4 rtl:mr-4 rtl:ml-0">
                            <p class="text-base font-medium text-blue-700">
                                Belum ada data kendaraan yang tersedia.
                            </p>
                            <p class="text-sm text-blue-600 mt-1">
                                Mulai dengan <a href="{{ route('rental.vehicles.create') }}" class="font-semibold hover:underline">menambahkan kendaraan baru</a> ke daftar Anda.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if ($vehicles->hasPages())
            <div class="mt-8">
                {{ $vehicles->links() }} {{-- Pastikan pagination view Anda sudah di-style dengan Tailwind --}}
            </div>
        @endif

    </div>
</div>
@endsection