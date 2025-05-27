@extends('layouts.app')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl leading-tight">
        Dashboard Pelanggan
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="p-6 rounded-md">
            <div class="bg-dark text-white p-6 rounded-md">



        <br> 
        <h2><span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold text-2xl">Pesanan anda sedang pending</span></h2>          
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
</div>
    @endif
            <br>
            <h2><span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold text-2xl">Rekomendasi kendaraan yang lain</span></h2>          
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vehicles as $vehicle)
            <div class="bg-dark shadow rounded overflow-hidden" style="margin-top: 10px;">
                @if($vehicle->image_path)
                    <img src="{{ asset('storage/' . $vehicle->image_path) }}" alt="{{ $vehicle->name }}"
                         class="w-full h-40 object-cover">
                @endif

                <div class="bg-dark p-4">
                    <h3 class="text-lg font-semibold">{{ $vehicle->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $vehicle->location }} - {{ $vehicle->category }}</p>
                    <p class="text-blue-600 font-bold mt-1">Rp{{ number_format($vehicle->price_per_day) }}/hari</p>
                    <a href="{{ route('vehicles.show', $vehicle->id) }}"
                       class="inline-block mt-3 text-blue-500 hover:underline text-sm">Lihat Detail</a>
                </div>
            </div>
            @endforeach
    </div>
</body>
@endsection
