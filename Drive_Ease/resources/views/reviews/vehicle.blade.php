@extends('layouts.app')

@section('content')
    <h2>Reviews for {{ $vehicle->name }}</h2>
    <div class="mb-4">
        @foreach($vehicle->reviews as $review)
            <div class="card mb-2">
                <div class="card-body">
                    <strong>{{ $review->user->name ?? 'User' }}</strong>
                    <span class="badge bg-primary">{{ $review->rating }} / 5</span>
                    <p>{{ $review->comment }}</p>
                    <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                </div>
            </div>
        @endforeach
    </div>
@endsection 