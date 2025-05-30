@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 md:mb-12">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
                Temukan <span class="text-blue-600">Kendaraan Terbaik</span> Anda
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-lg text-gray-500">
                Jelajahi berbagai pilihan mobil berkualitas untuk setiap kebutuhan dan petualangan.
            </p>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('vehicles.index') }}" class="bg-white p-6 rounded-xl shadow-2xl border border-gray-200 mb-10 md:mb-12">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-blue-500 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <h3 class="text-lg font-semibold text-gray-700">Filter Pencarian</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-5">
                <div>
                    <label for="location" class="sr-only">Lokasi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none rtl:right-0 rtl:left-auto rtl:pl-0 rtl:pr-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <input name="location" id="location" placeholder="Ketik lokasi..." value="{{ request('location') }}"
                               class="block w-full pl-10 rtl:pr-10 rtl:pl-4 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 placeholder-gray-500 py-2.5" />
                    </div>
                </div>
                <div>
                    <label for="category" class="sr-only">Kategori</label>
                    <select name="category" id="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 py-2.5">
                        <option value="">Semua Kategori</option>
                        @php $categories = ['SUV', 'MPV', 'Sedan', 'Hatchback', 'LCGC', 'City Car', 'Van', 'Lainnya']; @endphp
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="price_min" class="sr-only">Harga Minimum</label>
                    <input type="number" name="price_min" id="price_min" placeholder="Harga Min (Rp)" value="{{ request('price_min') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 placeholder-gray-500 py-2.5" min="0" />
                </div>
                <div>
                    <label for="price_max" class="sr-only">Harga Maksimum</label>
                    <input type="number" name="price_max" id="price_max" placeholder="Harga Max (Rp)" value="{{ request('price_max') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 placeholder-gray-500 py-2.5" min="0" />
                </div>
            </div>
            <div class="mt-6 text-center">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-3 border border-transparent rounded-lg shadow-md text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Cari Kendaraan
                </button>
            </div>
        </form>

        {{-- Vehicle List --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-8">
            @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-300 ease-in-out flex flex-col group transform hover:-translate-y-1">
                    <a href="{{ route('vehicles.show', $vehicle->id) }}" class="block overflow-hidden">
                        <img src="{{ $vehicle->image_path ? asset('storage/' . $vehicle->image_path) : 'https://placehold.co/600x400/E2E8F0/94A3B8?text=Mobil+' . urlencode($vehicle->name) }}" 
                             alt="Gambar {{ $vehicle->name }}"
                             class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out">
                    </a>

                    <div class="p-5 flex-grow flex flex-col">
                        <div class="mb-2">
                            <p class="text-xs text-blue-500 font-medium uppercase tracking-wider">{{ $vehicle->category }}</p>
                            <h3 class="text-xl font-bold text-gray-800">
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="hover:text-blue-600 transition line-clamp-1">{{ $vehicle->name }}</a>
                            </h3>
                            <p class="text-xs text-gray-500 flex items-center mt-1">
                                <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $vehicle->location }}
                            </p>
                        </div>
                        
                        @if($vehicle->average_rating)
                        <div class="flex items-center my-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($vehicle->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                            <span class="ml-1.5 rtl:mr-1.5 rtl:ml-0 text-xs text-gray-500">({{ number_format($vehicle->average_rating, 1) }})</span>
                        </div>
                        @else
                         <div class="my-2 h-4">
                            <p class="text-xs text-gray-400 italic">Belum ada rating</p>
                         </div>
                        @endif
                        
                        <p class="text-green-600 font-bold text-xl my-1">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}<span class="text-sm font-normal text-gray-500">/hari</span></p>
                        
                        <div class="mt-auto pt-4">
                            <a href="{{ route('vehicles.show', $vehicle->id) }}"
                               class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 transform hover:scale-105 group-hover:bg-blue-700">
                                Lihat Detail & Pesan
                                <svg class="ml-2 rtl:mr-2 rtl:ml-0 -mr-1 rtl:-ml-1 rtl:mr-0 h-5 w-5 transform transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                    <div class="bg-white border-2 border-dashed border-gray-300 p-10 rounded-lg text-center shadow-sm">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-800">Tidak Ada Kendaraan Ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Mohon maaf, kami tidak menemukan kendaraan yang sesuai dengan kriteria pencarian Anda. Coba kata kunci atau filter lain.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
        @if ($vehicles->hasPages())
            <div class="mt-12 pt-8 border-t border-gray-200">
                {{ $vehicles->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection