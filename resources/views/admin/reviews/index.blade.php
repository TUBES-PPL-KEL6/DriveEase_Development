@extends('layouts.admin')

@section('content')
    <h2>Review Moderation</h2>
    <form method="GET" class="mb-3">
        <label><input type="checkbox" name="reported" value="1" {{ request('reported') ? 'checked' : '' }}> Show only reported reviews</label>
        <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Vehicle</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Reported At</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->user->name ?? '-' }}</td>
                    <td>{{ $review->vehicle->name ?? '-' }}</td>
                    <td>{{ $review->rating }}</td>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $review->reported_at }}</td>
                    <td>{{ $review->report_reason }}</td>
                    <td>
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <input type="text" name="reason" placeholder="Reason for removal" required class="form-control mb-1">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this review?')">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $reviews->links() }}
@endsection 