<h2>Riwayat Pemesanan Saya</h2>

@foreach($bookings as $booking)
    <div style="margin-bottom: 20px;">
        <strong>{{ $booking->vehicle->name }}</strong><br>
        Tanggal: {{ $booking->start_date }} - {{ $booking->end_date }}<br>
        Status: <strong>{{ ucfirst($booking->status) }}</strong>
    </div>
@endforeach
