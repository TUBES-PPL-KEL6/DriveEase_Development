@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Kendaraan & Ulasan</h2>
    @foreach($vehicles as $vehicle)
        <div class="mb-8 p-4 bg-white rounded shadow">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <span class="font-semibold text-lg">{{ $vehicle->name }}</span>
                    <span class="ml-2 text-gray-500">({{ $vehicle->category }} - {{ $vehicle->location }})</span>
                    <span class="ml-2 text-xs text-gray-400">Oleh: {{ $vehicle->rental->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-yellow-500 font-bold">{{ $vehicle->reviews->avg('rating') ? number_format($vehicle->reviews->avg('rating'), 1) : '-' }} ⭐</span>
                    <span class="ml-2 text-gray-500">({{ $vehicle->reviews->count() }} ulasan)</span>
                </div>
            </div>
            @if($vehicle->reviews->count())
                <ul class="divide-y divide-gray-200">
                    @foreach($vehicle->reviews as $review)
                        <li class="py-2 flex justify-between items-center">
                            <div>
                                <span class="font-semibold">{{ $review->user->name }}</span>:
                                <span class="text-yellow-500">{{ $review->rating }}★</span>
                                <span class="ml-2 text-gray-700">{{ $review->comment }}</span>
                                <span class="ml-2 text-xs text-gray-400">({{ $review->created_at->format('d M Y') }})</span>
                            </div>
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger bg-danger text-white px-3 py-1 rounded" style="background-color: #dc3545; border: none;">Hapus</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500">Belum ada ulasan untuk kendaraan ini.</div>
            @endif
        </div>
    @endforeach
@endsection 