@extends('layouts.app')

@section('content')
    <h2>Submit a Review for {{ $vehicle->name }}</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('reviews.store', $vehicle) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <input type="number" min="1" max="5" class="form-control" id="rating" name="rating" required>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
@endsection 