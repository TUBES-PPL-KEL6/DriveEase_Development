<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Dashboard Pemilik Rental
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Section 1: Welcome & Shortcut --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700">Halo, {{ auth()->user()->name }} 👋</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola kendaraanmu dan pantau penyewaan dari dashboard ini.</p>

                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('rental.vehicles.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        + Tambah Kendaraan
                    </a>
                    <a href="{{ route('rental.vehicles.index') }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                        Lihat Daftar Kendaraan
                    </a>
                    <a href="{{ route('rental.rents.index') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        Daftar Pemesanan
                    </a>
                </div>
            </div>

            {{-- Section 2: Statistik Ringkas --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded shadow hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Total Kendaraan</p>
                    <h3 class="text-2xl font-bold text-blue-600">{{ auth()->user()->vehicles()->count() }}</h3>
                </div>
                <div class="bg-white p-4 rounded shadow hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Pemesanan Aktif</p>
                    <h3 class="text-2xl font-bold text-green-600">{{ $activeRents ?? '...' }}</h3>
                </div>
                <div class="bg-white p-4 rounded shadow hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Pemasukan Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-amber-600">Rp{{ number_format($monthlyRevenue ?? 0) }}</h3>
                </div>
            </div>

            {{-- Section 3: Info atau Tips --}}
            <div class="bg-white p-5 rounded shadow-md">
                <h4 class="font-semibold text-gray-700 mb-2">Tips</h4>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Perbarui ketersediaan kendaraan secara rutin.</li>
                    <li>Pastikan deskripsi dan gambar kendaraan lengkap.</li>
                    <li>Respon cepat terhadap pemesanan meningkatkan rating!</li>
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
