@extends('layouts.app')

@section('content')

<body>
<h2>Riwayat Pemesanan Saya</h2>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Nama Kendaraan</th>
            <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Tanggal Mulai</th>
            <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Tanggal Selesai</th>
            <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $booking->vehicle->name }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $booking->start_date }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $booking->end_date }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;"><strong>{{ ucfirst($booking->status) }}</strong></td>
            </tr>
        @endforeach
    </tbody>
</table>


</body>
@endsection