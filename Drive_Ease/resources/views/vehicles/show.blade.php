@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 py-10 md:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8 flex justify-between items-center">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center px-4 py-2 bg-white rounded-lg border border-gray-300 
                text-sm font-medium text-gray-700 hover:bg-gray-100 
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-5">
                    <div class="lg:col-span-3">
                        @if ($vehicle->image_path)
                            <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                                class="w-full h-72 sm:h-80 md:h-96 lg:h-[550px] object-cover">
                        @else
                            <div
                                class="w-full h-72 sm:h-80 md:h-96 lg:h-[550px] bg-gray-100 flex items-center justify-center">
                                <img src="https://placehold.co/800x600/E2E8F0/94A3B8?text=Gambar+{{ urlencode($vehicle->name) }}"
                                    alt="{{ $vehicle->name }}" class="max-w-full max-h-full object-contain">
                            </div>
                        @endif
                    </div>

                    <div class="lg:col-span-2 p-6 md:p-8 flex flex-col">
                        <div class="space-y-5 flex-grow">
                            <div>
                                <span
                                    class="text-xs text-blue-600 font-semibold uppercase tracking-wider">{{ $vehicle->category }}</span>
                                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mt-1">
                                    {{ $vehicle->name }}</h1>
                                <p class="text-sm text-gray-500 mt-1.5">{{ $vehicle->brand ?? '' }} &bull;
                                    {{ $vehicle->model ?? '' }} &bull; Tahun {{ $vehicle->year ?? 'N/A' }}</p>

                                <div class="flex items-center mt-3">
                                    @if ($vehicle->average_rating)
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= round($vehicle->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <a href="#reviews-section-anchor"
                                            class="ml-2 rtl:mr-2 rtl:ml-0 text-sm text-gray-600 hover:text-blue-600 hover:underline">({{ number_format($vehicle->average_rating, 1) }}
                                            dari {{ $vehicle->reviews_count ?? 0 }} ulasan)</a>
                                    @else
                                        <p class="text-sm text-gray-500 italic">Belum ada rating</p>
                                    @endif
                                </div>
                                <p class="text-3xl md:text-4xl font-bold text-green-600 mt-4">
                                    Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}<span
                                        class="text-lg font-medium text-gray-500">/hari</span>
                                </p>
                            </div>

                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                <h3 class="text-md font-semibold text-gray-700 mb-1">Informasi Kunci:</h3>
                                <ul class="space-y-1.5 text-sm text-gray-600">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0 text-blue-500 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                            </path>
                                        </svg>
                                        Lokasi: <span
                                            class="font-medium text-gray-700 ml-1 rtl:mr-1 rtl:ml-0">{{ $vehicle->location }}</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0 text-blue-500 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        Plat Nomor: <span
                                            class="font-medium text-gray-700 ml-1 rtl:mr-1 rtl:ml-0">{{ $vehicle->license_plate ?? 'N/A' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-auto border-t border-gray-200 pt-6">
                            @auth
                                @if (auth()->user()->role === 'pelanggan' || auth()->user()->role === 'customer')
                                    <h3 class="text-xl font-bold text-gray-800 mb-4">Sewa Kendaraan Ini</h3>
                                    <form action="{{ route('user.bookings.store', $vehicle->id) }}" method="POST"
                                        class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label for="start_date"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                                <input type="date" name="start_date" id="start_date"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 py-2.5"
                                                    required>
                                                @error('start_date')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="end_date"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                                <input type="date" name="end_date" id="end_date"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 py-2.5"
                                                    required>
                                                @error('end_date')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Integrasi Pilihan Driver --}}
                                        <div id="driver-selection-container" class="hidden"> {{-- Awalnya disembunyikan, tampil via JS --}}
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Driver
                                                (Opsional)
                                            </label>
                                            <div class="flex items-center gap-2">
                                                <select name="driver_id" id="driver-select"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 py-2.5">
                                                    <option value="">-- Tidak Menggunakan Driver --</option>
                                                </select>
                                                <button type="button" id="use-driver-button" onclick="openDriverModal()"
                                                    class="p-2.5 border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Gunakan jasa driver pilihan untuk perjalanan
                                                yang lebih aman dan nyaman.</p>
                                        </div>
                                        <div>
                                            <label for="side_note_booking_final"
                                                class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan
                                                (Opsional)</label>
                                            <textarea name="side_note" id="side_note_booking_final" rows="3"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 placeholder-gray-500"
                                                placeholder="Misal: permintaan khusus, jam antar/jemput, dll.">{{ old('side_note') }}</textarea>
                                            @error('side_note')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button type="submit" id="btn-pesan-sekarang"
                                            class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 transform hover:scale-105">
                                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Pesan Sekarang
                                        </button>
                                    </form>
                                @elseif(auth()->check() && isset($vehicle->owner_id) && auth()->id() === $vehicle->owner_id)
                                    <div class="text-center bg-indigo-50 p-6 rounded-lg">
                                        <p class="text-sm text-indigo-700">Anda adalah pemilik kendaraan ini.</p>
                                        <a href="{{ route('rental.vehicles.edit', $vehicle->id) }}"
                                            class="mt-2 inline-flex items-center px-4 py-2.5 border border-indigo-300 rounded-lg shadow-sm text-sm font-medium text-indigo-700 bg-white hover:bg-indigo-100 transition">
                                            <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Kelola Kendaraan
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center bg-blue-50 p-6 rounded-lg border border-blue-200">
                                    <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-lg font-medium text-gray-900">Siap untuk Menyewa?</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        <a href="{{ route('login') }}"
                                            class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">Masuk</a>
                                        atau <a href="{{ route('register') }}"
                                            class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">daftar</a>
                                        untuk melanjutkan pemesanan.
                                    </p>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>


            <div class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 md:p-8">
                <div class="mt-8 border-t pt-4">
                    <h3 class="text-lg font-semibold mb-4">Ulasan Pengguna</h3>

                    @auth
                        @php
                            $userReview = $vehicle->reviews->firstWhere('user_id', auth()->id());
                            $editMode = request()->query('edit') === 'true';
                        @endphp

                        @if (!$userReview)
                            {{-- Belum Ulasan: Form Baru --}}
                            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-3 mb-4">
                                @csrf
                                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                <div>
                                    <label class="block text-sm font-medium">Rating</label>
                                    <select name="rating" class="border rounded px-2 py-1 w-full">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Komentar</label>
                                    <textarea name="comment" rows="3" class="border rounded w-full px-2 py-1" required></textarea>
                                </div>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim
                                    Ulasan</button>
                            </form>
                        @elseif ($editMode)
                            {{-- Edit Mode: Tampilkan Form --}}
                            <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
                                <form action="{{ route('reviews.update', $userReview->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                    <div class="mb-2">
                                        <label class="text-sm font-medium">Rating</label>
                                        <select name="rating" class="w-full border rounded px-2 py-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $userReview->rating == $i ? 'selected' : '' }}>
                                                    {{ $i }} ⭐</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="text-sm font-medium">Komentar</label>
                                        <textarea name="comment" rows="3" class="w-full border rounded px-2 py-1">{{ $userReview->comment }}</textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Update</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="mt-10 md:mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-xl border border-gray-200 p-6 md:p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-5">Deskripsi Lengkap Kendaraan</h3>
                        <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($vehicle->description ?: 'Deskripsi lengkap tidak tersedia.')) !!}
                        </div>
                    </div>

                    <div class="lg:col-span-1 bg-white rounded-xl shadow-xl border border-gray-200 p-6 md:p-8" id="reviews-section-anchor">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Ulasan Pengguna ({{ $vehicle->reviews()->count() }})</h3>
                        @auth
                            @php
                                $userReview = $vehicle->reviews()->where('user_id', auth()->id())->first();
                                $completedRent = auth()->user()->rents()->where('vehicle_id', $vehicle->id)
                                    ->whereIn('status', ['selesai', 'completed'])->exists();
                                $canReview = $completedRent && !$userReview;
                                $editModeQueryParam = request()->query('edit_review');
                                $editMode = $userReview && $editModeQueryParam == $userReview->id;
                            @endphp


                            @if ($canReview && !$editMode)
                                <div
                                    class="mb-8 p-5 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border border-blue-200 rounded-lg shadow">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Bagikan Pengalaman Anda</h4>
                                    <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                        <div>
                                            <label for="rating_new_form"
                                                class="block text-sm font-medium text-gray-700 mb-1">Rating Anda</label>
                                            <div
                                                class="flex flex-row-reverse justify-end space-x-1 space-x-reverse rtl:space-x-1 rtl:justify-start">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" name="rating"
                                                        id="rating_new_form_{{ $i }}" value="{{ $i }}"
                                                        class="sr-only peer" {{ old('rating') == $i ? 'checked' : '' }}
                                                        required>
                                                    <label for="rating_new_form_{{ $i }}"
                                                        class="cursor-pointer text-gray-300 peer-hover:text-yellow-400 hover:text-yellow-300 peer-checked:text-yellow-400 transition-colors">
                                                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                            </path>
                                                        </svg>
                                                    </label>
                                                @endfor
                                            </div>
                                            @error('rating')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="comment_new_form"
                                                class="block text-sm font-medium text-gray-700 mb-1">Komentar Anda</label>
                                            <textarea name="comment" id="comment_new_form" rows="3"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30 sm:text-sm text-gray-900 placeholder-gray-500"
                                                placeholder="Ceritakan pengalaman Anda..." required>{{ old('comment') }}</textarea>
                                            @error('comment')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button type="submit"
                                            class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:scale-105">
                                            Kirim Ulasan
                                        </button>
                                    </form>
                                </div>
                            @elseif ($userReview && $editMode)
                                <div class="mb-8 p-5 bg-yellow-50 border border-yellow-300 rounded-lg shadow-sm">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Edit Ulasan Anda</h4>
                                    <form action="{{ route('reviews.update', $userReview->id) }}" method="POST"
                                        class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                        <div>
                                            <label for="rating_edit_form"
                                                class="block text-sm font-medium text-gray-700 mb-1">Rating Anda</label>
                                            <div
                                                class="flex flex-row-reverse justify-end space-x-1 space-x-reverse rtl:space-x-1 rtl:justify-start">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" name="rating"
                                                        id="rating_edit_form_{{ $i }}"
                                                        value="{{ $i }}" class="sr-only peer"
                                                        {{ old('rating', $userReview->rating) == $i ? 'checked' : '' }}
                                                        required>
                                                    <label for="rating_edit_form_{{ $i }}"
                                                        class="cursor-pointer text-gray-300 peer-hover:text-yellow-400 hover:text-yellow-300 peer-checked:text-yellow-400 transition-colors">
                                                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                            </path>
                                                        </svg>
                                                    </label>
                                                @endfor
                                            </div>
                                            @error('rating')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="comment_edit_form"
                                                class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                                            <textarea name="comment" id="comment_edit_form" rows="3"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-30 sm:text-sm text-gray-900"
                                                required>{{ old('comment', $userReview->comment) }}</textarea>
                                            @error('comment')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button type="submit"
                                                class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition transform hover:scale-105">
                                                Update Ulasan
                                            </button>
                                            <a href="{{ route('vehicles.show', $vehicle->slug ?? $vehicle->id) }}#reviews-section-anchor"
                                                class="text-sm text-gray-600 hover:underline">Batal</a>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endauth

                        <div class="space-y-6">
                            @forelse ($vehicle->reviews()->latest()->take(5)->get() as $review)
                                <article
                                    class="p-5 bg-gray-50 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-base font-semibold">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-sm text-gray-800">{{ $review->user->name }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $review->created_at->translatedFormat('d M Y, \p\u\k\u\l H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                            <span
                                                class="ml-1.5 rtl:mr-1.5 rtl:ml-0 text-xs font-medium text-gray-600">({{ $review->rating }}/5)</span>
                                        </div>
                                    </div>
                                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                                        {!! nl2br(e($review->comment)) !!}
                                    </div>
                                    @if (auth()->check() && $review->user_id === auth()->id() && !$editMode)
                                        {{-- Jangan tampilkan jika sedang edit review ini --}}
                                        <div class="mt-3 pt-3 border-t border-gray-100 text-xs flex items-center gap-4">
                                            <a href="{{ route('vehicles.show', $vehicle->slug ?? $vehicle->id) }}?edit_review={{ $review->id }}#reviews-section-anchor"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium hover:underline">
                                                <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form id="delete-review-form-{{ $review->id }}"
                                                action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="confirmDeleteReview('{{ $review->id }}')"
                                                    class="inline-flex items-center text-red-500 hover:text-red-600 font-medium hover:underline">
                                                    <svg class="w-3.5 h-3.5 mr-1 rtl:ml-1 rtl:mr-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </article>
                            @empty
                                <div class="text-center py-10">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Ulasan</h3>
                                    <p class="mt-1 text-sm text-gray-500">Jadilah yang pertama mengulas kendaraan ini
                                        setelah Anda menyewanya.</p>
                                </div>
                            @endforelse

                            @if (($vehicle->reviews_count ?? 0) > 5)
                                <div class="text-center mt-8">
                                    {{-- Ganti dengan route ke halaman semua ulasan, misal: {{ route('vehicles.reviews', $vehicle->slug ?? $vehicle->id) }} --}}
                                    <a href="#"
                                        class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition group">
                                        Lihat semua {{ $vehicle->reviews_count }} ulasan
                                        <span aria-hidden="true"
                                            class="inline-block transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1">&rarr;</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="driverModal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-75">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl">
                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Profil Driver Tersedia
                        </h3>
                        <button type="button" onclick="closeDriverModal()" id="close-driver-modal"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div
                        class="p-6 space-y-6 max-h-[70vh] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="driver-profile-content">
                            {{-- Konten driver akan diisi oleh JavaScript --}}
                            <p class="text-gray-500 col-span-full text-center">Pilih tanggal mulai dan selesai untuk
                                melihat driver yang tersedia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Fungsi Konfirmasi Hapus Ulasan (dari HEAD, sedikit modifikasi)
            function confirmDeleteReview(reviewId) {
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Ulasan yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus ulasan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-review-form-' + reviewId).submit();
                    }
                });
            }

            // Validasi Tanggal (dari HEAD, sedikit penyesuaian)
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const driverSelectionContainer = document.getElementById('driver-selection-container');

            if (startDateInput && endDateInput) {
                const today = "{{ now()->format('Y-m-d') }}";
                const tomorrow = "{{ now()->addDay()->format('Y-m-d') }}";

                startDateInput.min = today;
                endDateInput.min = startDateInput.value ? (startDateInput.value > today ? startDateInput.value : today) :
                    tomorrow;


                function updateEndDateMin() {
                    if (startDateInput.value) {
                        let nextDayOfStartDate = new Date(startDateInput.value);
                        nextDayOfStartDate.setDate(nextDayOfStartDate.getDate() + 1);
                        const minEndDate = nextDayOfStartDate.toISOString().split('T')[0];

                        endDateInput.min = minEndDate;
                        if (endDateInput.value && endDateInput.value < minEndDate) {
                            endDateInput.value = minEndDate;
                        }
                    } else {
                        endDateInput.min = tomorrow;
                    }
                    // Panggil updateDrivers setelah tanggal berubah
                    if (startDateInput.value && endDateInput.value) {
                        updateDrivers();
                        if (driverSelectionContainer) driverSelectionContainer.classList.remove('hidden');
                    } else {
                        if (driverSelectionContainer) driverSelectionContainer.classList.add('hidden');
                    }
                }

                startDateInput.addEventListener('change', updateEndDateMin);
                endDateInput.addEventListener('change', function() {
                    if (startDateInput.value && endDateInput.value) {
                        updateDrivers();
                        if (driverSelectionContainer) driverSelectionContainer.classList.remove('hidden');
                    } else {
                        if (driverSelectionContainer) driverSelectionContainer.classList.add('hidden');
                    }
                });

                // Initial check
                if (startDateInput.value) updateEndDateMin();
            }

            // Fungsi Modal Driver (dari a3b21da...)
            function openDriverModal() {
                const driverModal = document.getElementById('driverModal');
                if (driverModal) {
                    driverModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Mencegah scroll background
                }
            }

            function closeDriverModal() {
                const driverModal = document.getElementById('driverModal');
                if (driverModal) {
                    driverModal.classList.add('hidden');
                    document.body.style.overflow = 'auto'; // Kembalikan scroll background
                }
            }

            // Event listener untuk menutup modal jika klik di luar area konten modal
            const driverModalElement = document.getElementById('driverModal');
            if (driverModalElement) {
                driverModalElement.addEventListener('click', function(e) {
                    if (e.target === this) { // Jika target klik adalah elemen modal itu sendiri (area luar)
                        closeDriverModal();
                    }
                });
            }


            // Fungsi AJAX untuk mengambil Driver (dari a3b21da...)
            const driverSelect = document.getElementById('driver-select');

            function selectDriver(driverId, driverName) {
                if (driverSelect) {
                    // Cek jika opsi sudah ada
                    let existingOption = driverSelect.querySelector(`option[value="${driverId}"]`);
                    if (!existingOption) {
                        const option = document.createElement('option');
                        option.value = driverId;
                        option.textContent = driverName;
                        driverSelect.appendChild(option);
                    }
                    driverSelect.value = driverId; // Pilih driver yang diklik
                }
                closeDriverModal();
            }

            async function updateDrivers() {
                const startDateValue = startDateInput.value;
                const endDateValue = endDateInput.value;
                const driverProfileContent = document.getElementById('driver-profile-content');

                if (!startDateValue || !endDateValue || !driverProfileContent) {
                    if (driverProfileContent) driverProfileContent.innerHTML =
                        '<p class="text-gray-500 col-span-full text-center">Mohon pilih tanggal mulai dan selesai terlebih dahulu.</p>';
                    if (driverSelect) driverSelect.innerHTML =
                        '<option value="">-- Tidak Menggunakan Driver --</option>'; // Reset select
                    return;
                }

                driverProfileContent.innerHTML = '<p class="text-gray-500 col-span-full text-center">Mencari driver...</p>';

                try {
                    const response = await fetch(
                        "{{ route('user.drivers.available', ['vehicle' => $vehicle->id]) }}", { // Pastikan route ini ada dan menerima vehicle ID
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                start_date: startDateValue,
                                end_date: endDateValue,
                                vehicle_id: "{{ $vehicle->id }}" // Kirim juga vehicle_id jika diperlukan di backend
                            })
                        });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    const drivers = Array.isArray(data.drivers) ? data.drivers : (Array.isArray(data) ? data : []);


                    if (driverSelect) {
                        const currentSelectedDriver = driverSelect.value;
                        driverSelect.innerHTML = ''; // Kosongkan opsi yang ada

                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '-- Tidak Menggunakan Driver --';
                        driverSelect.appendChild(defaultOption);

                        drivers.forEach(driver => {
                            const option = document.createElement('option');
                            option.value = driver.id;
                            option.textContent = driver.name;
                            driverSelect.appendChild(option);
                        });
                        // Kembalikan pilihan jika masih valid
                        if (drivers.find(d => d.id == currentSelectedDriver)) {
                            driverSelect.value = currentSelectedDriver;
                        }
                    }

                    if (drivers.length > 0) {
                        driverProfileContent.innerHTML = drivers.map(driver => `
                    <div class="driver-profile-item bg-white rounded-lg border border-gray-300 p-4 cursor-pointer hover:shadow-lg hover:border-blue-500 transition-all" onclick="selectDriver('${driver.id}', '${driver.name}')">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full object-cover" src="${driver.photo || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(driver.name) + '&background=EBF4FF&color=007BFF&font-size=0.5'}" alt="${driver.name}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-md font-semibold text-gray-800 truncate">${driver.name}</h4>
                                <p class="text-sm text-gray-600 truncate">${driver.phone || 'No phone'}</p>
                                <p class="text-xs text-gray-500 truncate">${driver.email || 'No email'}</p>
                            </div>
                        </div>
                    </div>
                `).join('');
                    } else {
                        driverProfileContent.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="mt-2 text-sm text-gray-500">Tidak ada driver yang tersedia untuk tanggal yang dipilih.</p>
                    </div>`;
                    }
                } catch (error) {
                    console.error('Error fetching drivers:', error);
                    driverProfileContent.innerHTML =
                        `<p class="text-red-500 col-span-full text-center">Gagal memuat driver. ${error.message}</p>`;
                }
            }
        </script>
    @endpush

    @push('styles')
        <style>
            /* Menyembunyikan radio button asli untuk rating stars */
            input[type="radio"].sr-only.peer {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border-width: 0;
            }

            /* Styling untuk bintang interaktif di form review */
            .flex-row-reverse label svg {
                transition: color 0.2s ease-in-out;
            }

            /* Scrollbar styling (opsional, bisa disesuaikan) */
            .scrollbar-thin {
                scrollbar-width: thin;
                scrollbar-color: #a0aec0 #edf2f7;
                /* thumb track */
            }

            .scrollbar-thin::-webkit-scrollbar {
                width: 8px;
            }

            .scrollbar-thin::-webkit-scrollbar-track {
                background: #edf2f7;
                border-radius: 10px;
            }

            .scrollbar-thin::-webkit-scrollbar-thumb {
                background-color: #a0aec0;
                border-radius: 10px;
                border: 2px solid #edf2f7;
            }
        </style>
    @endpush
