@extends('layouts.app')

@section('content')
<h2>Atur Jadwal untuk {{ $driver->name }}</h2>
<form method="POST" action="{{ route('rental.drivers.schedule', $driver->id) }}">
    @csrf
    <label>Senin:</label>
    <input type="text" name="schedule[monday]" value="{{ $driver->schedule['monday'] ?? '' }}">
    <label>Selasa:</label>
    <input type="text" name="schedule[tuesday]" value="{{ $driver->schedule['tuesday'] ?? '' }}">
    <!-- Tambahkan hari lainnya jika perlu -->
    <button type="submit">Simpan Jadwal</button>
</form>
@endsection
