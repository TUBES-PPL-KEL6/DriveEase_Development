@extends('layouts.app')

@section('content')
    <h2>Reviews for {{ $user->name }}</h2>
    <div class="mb-4">
        @if($reviews->isEmpty())
            <p>No reviews yet.</p>
        @else
            @foreach($reviews as $review)
                <div class="card mb-2">
                    <div class="card-body">
                        <strong>{{ $review->reviewer->name }}</strong>
                        <span class="badge bg-primary">{{ $review->rating }} / 5</span>
                        <p>{{ $review->comment }}</p>
                        <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            @endforeach
            <div>{{ $reviews->links() }}</div>
        @endif
    </div>
@endsection 