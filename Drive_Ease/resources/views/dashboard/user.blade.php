@extends('layouts.app')

@section('styles')
    <style>
        /* CSS Umum untuk tabel */
        table, th, td {
            border: none !important;
        }
        table {
            border-collapse: collapse;
        }
    </style>
@endsection

@section('content')

<body>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Dashboard Pelanggan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="p-6 rounded-md">
                <div class="bg-dark text-white p-6 rounded-md">

                <p class="text-white">Selamat datang, <span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold"> {{ auth()->user()->name }}</span>!</p>

                {{-- Ubah kelas div di bawah ini ke 'container-buttons' --}}
                <div class="container-buttons">
                    <a href="{{ route('vehicles.index') }}"
                        class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Cari Kendaraan
                    </a>

                    <form method="POST" action="{{ route('checkout') }}" class="inline-block">
                        @csrf

                        <button type="submit" class="inline bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">

                            Checkout
                        </button>
                    </form>
                </div>

                
                <br> 
                <h2><span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold text-2xl">Status pembayaran terakhir</span></h2>
                @if($bookings->count())
                <table border="1" class="table border-0" style="margin-top: 10px;">
                <thead style="background-color: #00ffae; font-weight: bold;">
                        <tr>
                            <th>Nama Kendaraan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        <tr>
                            <td>{{ $bookings[0]->vehicle->name }}</td>
                            <td>{{ $bookings[0]->start_date }}</td>
                            <td>{{ $bookings[0]->end_date }}</td>
                            <td><strong>{{ ucfirst($bookings[0]->status) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                @endif

                <br>
                <h3><span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold text-2xl">Riwayat Rental</span></h3>
               @if($bookings->count())
    <table class="table border-0" style="margin-top: 10px;">
        <thead style="background-color: #00ffae; font-weight: bold;">
            <tr>
                <th>Nama Kendaraan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="text-white">
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->vehicle->name }}</td>
                    <td>{{ $booking->start_date }}</td>
                    <td>{{ $booking->end_date }}</td>
                    <td><strong>{{ ucfirst($booking->status) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

            <br>
            <h2><span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold text-2xl">Rekomendasi kendaraan yang lain</span></h2>          
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vehicles as $vehicle)
            <div class="bg-dark shadow rounded overflow-hidden" style="margin-top: 10px;">
                @if($vehicle->image_path)
                    <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                         class="w-full h-40 object-cover">
                @endif
                        <tr>
                            <td>ID</td>
                            <td>kendaraan</td>
                            <td>harga</td>
                            <td>tanggal mulai</td>
                            <td>tanggal akhir</td>
                        </tr>
                </tbody>
                </table>
            </div>
            @endforeach
    </div>
</body>

@endsection

