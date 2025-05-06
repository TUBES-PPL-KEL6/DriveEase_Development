<<<<<<< HEAD
<<<<<<< HEAD
{{-- @if (session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
        {{ session('success') }}
=======
@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Pelanggan</h1>

    <div class="bg-white shadow p-4 rounded-md">
        <p class="text-gray-700">Selamat datang, {{ auth()->user()->name }}!</p>
        <a href="{{ route('vehicles.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cari Kendaraan
        </a>
>>>>>>> main
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

=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pelanggan
        </h2>
    </x-slot>

<<<<<<< HEAD
<<<<<<< HEAD
    <form method="POST" action="{{ route('checkout') }}" style="margin-top: 20px;">
=======
    <form method="GET" action="{{ route('checkout') }}" style="margin-top: 20px;">
>>>>>>> main
        @csrf
        <button type="submit" class="btn btn-primary">checkout</button>
    </form>
</x-app-layout>
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
>>>>>>> main
=======
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow p-6 rounded-md">
                <p class="text-gray-700">Selamat datang, {{ auth()->user()->name }}!</p>

                <div class="mt-4 space-x-2">
                    <a href="{{ route('vehicles.index') }}"
                       class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Cari Kendaraan
                    </a>

                    <form method="POST" action="{{ route('checkout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
