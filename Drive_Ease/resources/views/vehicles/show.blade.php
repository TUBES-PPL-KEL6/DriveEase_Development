@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-dark shadow rounded p-6">
        {{-- Gambar dan Info Kendaraan --}}
        @if ($vehicle->image_path)
            <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                class="w-full h-64 object-cover mb-4 rounded">
        @endif

        <h2 class="text-2xl font-bold">{{ $vehicle->name }}</h2>
        <p class="text-gray-500">{{ $vehicle->location }} - {{ $vehicle->category }}</p>
        <p class="text-blue-600 text-lg font-bold mt-2">Rp{{ number_format($vehicle->price_per_day) }}/hari</p>

        {{-- Rating Rata-rata --}}
        <div class="mt-2">
            @if ($vehicle->average_rating)
                <div class="flex items-center gap-1 text-yellow-500">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="{{ $i <= round($vehicle->average_rating) ? 'orange' : 'none' }}" viewBox="0 0 24 24"
                            stroke="orange" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.234 6.869h7.215c.969 0 1.371 1.24.588 1.81l-5.838 4.245
                                                                             2.234 6.869c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.838 4.245c-.783.57-1.838-.197-1.538-1.118l2.234-6.869
                                                                             -5.838-4.245c-.783-.57-.38-1.81.588-1.81h7.215l2.234-6.869z" />
                        </svg>
                    @endfor
                    <span class="text-sm text-gray-600 ml-2">({{ number_format($vehicle->average_rating, 1) }})</span>
                </div>
            @else
                <p class="text-gray-400 italic">Belum ada rating</p>
            @endif
        </div>

        {{-- Deskripsi --}}
        <div class="mt-4">
            <h3 class="text-lg font-semibold">Deskripsi</h3>
            <p class="text-gray-700">{{ $vehicle->description }}</p>
        </div>

        {{-- Rating Rata-rata --}}
        <div class="mt-2">
            @if ($vehicle->average_rating)
                <div class="flex items-center gap-1 text-yellow-500">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="{{ $i <= round($vehicle->average_rating) ? 'orange' : 'none' }}" viewBox="0 0 24 24"
                            stroke="orange" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.234 6.869h7.215c.969 0 1.371 1.24.588 1.81l-5.838 4.245
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             2.234 6.869c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.838 4.245c-.783.57-1.838-.197-1.538-1.118l2.234-6.869
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             -5.838-4.245c-.783-.57-.38-1.81.588-1.81h7.215l2.234-6.869z" />
                        </svg>
                    @endfor
                    <span class="text-sm text-gray-600 ml-2">({{ number_format($vehicle->average_rating, 1) }})</span>
                </div>
            @else
                <p class="text-gray-400 italic">Belum ada rating</p>
            @endif
        </div>

        {{-- Deskripsi --}}
        <div class="mt-4">
            <h3 class="text-lg font-semibold">Deskripsi</h3>
            <p class="text-gray-700">{{ $vehicle->description }}</p>
        </div>

        {{-- Form Pemesanan --}}
        @auth
            @if (auth()->user()->role === 'pelanggan')
                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-semibold mb-2">Form Pemesanan</h3>
                    <form action="{{ route('user.bookings.store', $vehicle->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" value=""
                                class="bg-dark border rounded px-3 py-2 w-full" required onload="this.value=''">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" value=""
                                class="bg-dark border rounded px-3 py-2 w-full" required onload="this.value=''">
                        </div>

                        <div class="block text-sm font-medium space-y-2" id="driver-container">
                            <label class="block text-sm font-medium">Driver Tersedia</label>
                            <div class="flex gap-2">
                                <select name="driver_id" class="bg-dark border rounded px-3 py-2 w-full" id="driver-select">
                                    <option value="" selected>-- Tidak Menggunakan Driver --</option>
                                </select>
                                <button type="button"
                                    class="border border-blue-600 text-blue-600 px-4 py-2 rounded hover:bg-blue-700 hover:text-white"
                                    id="use-driver-button" onclick="openDriverModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </button>

                                <!-- Driver Modal -->
                                <div id="driverModal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50">
                                    <div class="flex items-center justify-center min-h-screen px-4">
                                        <div class="relative bg-dark rounded-lg shadow-lg w-full max-w-2xl">
                                            <!-- Modal header -->
                                            <div class="flex items-start justify-between p-4 border-b">
                                                <h3 class="text-xl font-semibold text-white">
                                                    Profil Driver
                                                </h3>
                                                <button type="button" onclick="closeDriverModal()"
                                                    class="text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div
                                                class="bg-dark p-6 space-y-6 max-h-[500px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="driver-profile-content">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                Gunakan jasa driver pilihan untuk perjalanan yang lebih aman dan nyaman.
                            </div>
                        </div>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Pesan Sekarang
                        </button>

                    </form>
                </div>
            @endif
        @endauth

        {{-- Ulasan Pengguna --}}
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
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim
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

            {{-- Semua Ulasan --}}
            <div class="space-y-3">
                @forelse ($vehicle->reviews as $review)
                    <div class="bg-gray-100 p-4 rounded border relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-sm">{{ $review->user->name }}</p>
                                <p class="text-gray-700 mt-1 text-sm">{{ $review->comment }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-yellow-500 text-sm font-medium">{{ $review->rating }} ⭐</span>

                                @if ($review->user_id === auth()->id())
                                    <div class="flex gap-2 text-xs">
                                        <a href="{{ request()->url() }}?edit=true"
                                            class="text-blue-600 hover:underline">Edit</a>
                                        <form id="delete-review-form-{{ $review->id }}"
                                            action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button type="button" onclick="confirmDelete({{ $review->id }})"
                                            dusk="btn-hapus-review" class="text-red-600 hover:underline">Hapus</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Belum ada ulasan untuk kendaraan ini.</p>
                @endforelse
            </div>
        </div>



    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(reviewId) {
            Swal.fire({
                title: 'Yakin hapus ulasan?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-review-form-' + reviewId).submit();
                }
            });
        }
    </script>
    <script>
        function openDriverModal() {
            document.getElementById('driverModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDriverModal() {
            document.getElementById('driverModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('driverModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDriverModal();
            }
        });
    </script>
    <script>
        const startDate = document.querySelector('#start_date');
        const endDate = document.querySelector('#end_date');
        const driverSelect = document.querySelector('#driver-select');
        const driverContainer = document.querySelector('#driver-container');
        driverContainer.classList.add('hidden');

        startDate.addEventListener('change', updateDrivers);
        endDate.addEventListener('change', updateDrivers);

        // Memilih Driver
        function selectDriver(driverId) {
            driverSelect.value = driverId;
            closeDriverModal();
        }

        function updateDrivers() {
            const startDateValue = startDate.value;
            const endDateValue = endDate.value;

            fetch(
                    `{{ route('user.drivers.available', $vehicle->id) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            start_date: startDateValue,
                            end_date: endDateValue
                        })
                    })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    driverContainer.classList.remove('hidden');
                    driverSelect.innerHTML = '';

                    // Menambahkan opsi default "tidak ada driver"
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = '-- Tidak Menggunakan Driver --';
                    driverSelect.appendChild(defaultOption);

                    // Pastikan data adalah array
                    const drivers = Array.isArray(data) ? data : [];

                    // Menambahkan opsi driver ke pilihan
                    drivers.forEach(driver => {
                        const option = document.createElement('option');
                        option.value = driver.id;
                        option.textContent = driver.name;
                        driverSelect.appendChild(option);
                    });

                    // Memperbarui konten profil driver
                    const driverProfileContent = document.getElementById('driver-profile-content');
                    if (drivers.length > 0) {
                        driverProfileContent.innerHTML = drivers.map(driver => `
                            <div class="bg-dark rounded-lg border border-gray-200 p-4 cursor-pointer hover:shadow-lg hover:shadow-gray-400" onclick="selectDriver(${driver.id})">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-12 w-12 rounded-full object-cover" src="${driver.photo || 'https://i.ytimg.com/vi/J6NBjUlKzr4/mqdefault.jpg'}" alt="${driver.name}">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold">${driver.name}</h4>
                                        <p class="text-white">${driver.phone_number || 'No phone number'}</p>
                                        <p class="text-sm text-white">${driver.email || 'No email'}</p>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        driverProfileContent.innerHTML = `
                            <div class="bg-gray-100 rounded-lg p-4 text-center">
                                <p class="text-gray-500">No drivers available for selected dates</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(reviewId) {
            Swal.fire({
                title: 'Yakin hapus ulasan?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-review-form-' + reviewId).submit();
                }
            });
        }
    </script>
@endpush
