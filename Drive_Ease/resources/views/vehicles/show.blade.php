<h1>{{ $vehicle->name }}</h1>
<p>Lokasi: {{ $vehicle->location }}</p>
<p>Kategori: {{ $vehicle->category }}</p>
<p>Harga: Rp{{ number_format($vehicle->price_per_day) }}/hari</p>
<p>{{ $vehicle->description }}</p>

<h3>Ulasan:</h3>
@foreach($vehicle->reviews as $review)
    <div>
        <strong>{{ $review->user->name }}</strong> - ⭐ {{ $review->rating }}<br>
        <p>{{ $review->comment }}</p>
    </div>
@endforeach

@if(auth()->user()->role === 'pelanggan')
    <h3>Form Pemesanan</h3>
    <form action="{{ route('bookings.store', $vehicle->id) }}" method="POST">
        @csrf
        <label for="start_date">Tanggal Mulai:</label>
        <input type="date" name="start_date" required>
        <label for="end_date">Tanggal Selesai:</label>
        <input type="date" name="end_date" required>
        <button type="submit">Pesan Kendaraan</button>
    </form>
@endif
