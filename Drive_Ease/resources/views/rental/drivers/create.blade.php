@extends('layouts.app')

@section('content')
<h2>Tambah Driver</h2>
<form method="POST" action="{{ route('rental.drivers.store') }}">
    @csrf
    <label>Nama:</label>
    <input type="text" name="name" required>
    <label>Telepon:</label>
    <input type="text" name="phone" required>
    <button type="submit">Simpan</button>
</form>
@endsection
