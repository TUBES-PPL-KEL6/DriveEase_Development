@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard Ulasan Kendaraan Anda</h1>
    @forelse ($vehicles as $vehicle)
        <div class="mb-8 p-4 bg-white rounded shadow">
            <div class="flex justify-between items-center mb-2">
                <div class="font-semibold text-lg">{{ $vehicle->name }}</div>
                <div>
                    <span class="text-yellow-500 font-bold">{{ $vehicle->reviews->avg('rating') ? number_format($vehicle->reviews->avg('rating'), 1) : '-' }} ⭐</span>
                    <span class="ml-2 text-gray-500">({{ $vehicle->reviews->count() }} ulasan)</span>
                </div>
            </div>
            @if($vehicle->reviews->count())
                <ul class="divide-y divide-gray-200">
                    @foreach($vehicle->reviews as $review)
                        <li class="py-2">
                            <span class="font-semibold">{{ $review->user->name }}</span>:
                            <span class="text-yellow-500">{{ $review->rating }}★</span>
                            <span class="ml-2 text-gray-700">{{ $review->comment }}</span>
                            <span class="ml-2 text-xs text-gray-400">({{ $review->created_at->format('d M Y') }})</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500">Belum ada ulasan untuk kendaraan ini.</div>
            @endif
        </div>
    @empty
        <div class="p-4 bg-gray-100 rounded">Anda belum memiliki kendaraan.</div>
    @endforelse
@endsection 