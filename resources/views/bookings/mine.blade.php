@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Booking Saya</h1>
    <div class="space-y-4">
        @forelse ($bookings as $booking)
            <div class="p-4 bg-white rounded shadow">
                <div class="font-semibold">{{ $booking->vehicle->name ?? 'Kendaraan tidak ditemukan' }}</div>
                <div>Tanggal Mulai: {{ $booking->start_date }}</div>
                <div>Tanggal Selesai: {{ $booking->end_date }}</div>
                <div>Status: <span class="font-semibold">{{ ucfirst($booking->status) }}</span></div>
                @if ($booking->status === 'selesai')
                    @php
                        $alreadyReviewed = $booking->vehicle->reviews()->where('user_id', auth()->id())->exists();
                    @endphp
                    @if (!$alreadyReviewed)
                        <a href="{{ route('reviews.vehicle', $booking->vehicle->id) }}#review-form" class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Beri Ulasan</a>
                    @else
                        <span class="inline-block mt-2 px-4 py-2 bg-green-100 text-green-800 rounded">Sudah Diulas</span>
                    @endif
                @endif
            </div>
        @empty
            <div class="p-4 bg-gray-100 rounded">Belum ada booking.</div>
        @endforelse
    </div>
@endsection
