<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Rental') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4">Halo, {{ auth()->user()->name }}! Kelola kendaraanmu di bawah ini.</p>

                <a href="{{ route('rental.vehicles.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Kelola Kendaraan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Rental</h1>

    <div class="bg-white p-6 rounded shadow">
        <p class="mb-4">Halo, {{ auth()->user()->name }}! Kelola kendaraanmu di bawah ini.</p>

        <a href="{{ route('rental.vehicles.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kelola Kendaraan
        </a>
    </div>
@endsection
