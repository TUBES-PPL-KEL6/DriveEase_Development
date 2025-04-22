<h1>Daftar Kendaraan</h1>

<form method="GET">
    <input name="location" placeholder="Lokasi">
    <select name="category">
        <option value="">Kategori</option>
        <option>SUV</option>
        <option>MPV</option>
        <option>Hatchback</option>
    </select>
    <input type="number" name="price_min" placeholder="Harga Min">
    <input type="number" name="price_max" placeholder="Harga Max">
    <button type="submit">Cari</button>
</form>

@foreach($vehicles as $v)
    <div style="margin: 20px 0">
        <h3>{{ $v->name }} - Rp{{ number_format($v->price_per_day) }}/hari</h3>
        <p>{{ $v->location }} | {{ $v->category }}</p>
        <a href="{{ route('vehicles.show', $v->id) }}">Lihat Detail</a>
    </div>
@endforeach
