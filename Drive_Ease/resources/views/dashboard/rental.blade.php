@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Rental</h1>

    <div class="bg-white p-6 rounded shadow">
        <p class="mb-4">Halo, {{ auth()->user()->name }}! Kelola kendaraanmu di bawah ini.</p>

        <a href="{{ route('rental.vehicles.index') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kelola Kendaraan
        </a>
    </div>
@endsection
