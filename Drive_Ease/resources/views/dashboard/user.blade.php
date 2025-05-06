@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Pelanggan</h1>

    <div class="bg-white shadow p-4 rounded-md">
        <p class="text-gray-700">Selamat datang, {{ auth()->user()->name }}!</p>
        <a href="{{ route('vehicles.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cari Kendaraan
        </a>
    </div>
<<<<<<< Updated upstream
@endsection
=======
@endif


<h1>Dashboard Pelanggan</h1>
<p>Selamat datang, {{ auth()->user()->name }}</p>

<form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
    @csrf
    <button type="submit">Logout</button>
</form>

<form method="POST" action="{{ route('checkout') }}" style="margin-top: 20px;">
    @csrf
    <button type="submit">checkout</button>
</form> --}}

<x-app-layout>
    <x-slot name="header">
        <h1>Dashboard Pelanggan</h1>
    </x-slot>

    <form method="GET" action="{{ route('checkout') }}" style="margin-top: 20px;">
        @csrf
        <button type="submit" class="btn btn-primary">checkout</button>
    </form>
</x-app-layout>
>>>>>>> Stashed changes
