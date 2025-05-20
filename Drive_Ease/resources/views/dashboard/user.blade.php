@extends('layouts.app')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pelanggan
        </h2>
    </x-slot>

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
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
