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
