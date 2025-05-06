@extends('layouts.app')

@section('content')

    <h2>Payment History</h2>

    <!-- Include Bootstrap CSS here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Car</th>
            <th>Price</th>
            <th>Created At</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($paymentHistories as $history)
            <tr>
                <td>{{ $history->id }}</td>
                <td>{{ $history->user_id }}</td>
                <td>{{ $history->vehicle_id }}</td>
                <td>{{ $history->start_date }}</td>
                <td>{{ $history->end_date }}</td>
                <td>
                    <strong>{{ ucfirst($history->status) }}</strong><br><br>
                    <form action="{{ route('admin.booking.approve', $history->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                    </form>

                    <form action="{{ route('admin.booking.cancel', $history->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>

@endsection

<!-- Include Bootstrap JS and Popper here -->
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
