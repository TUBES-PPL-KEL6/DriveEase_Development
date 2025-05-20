@extends('layouts.app')

@section('styles') {{-- Ini adalah tempat yang benar untuk CSS kustom Anda --}}
    <style>
        /* CSS Umum untuk tabel */
        table, th, td {
            border: none !important;
        }
        table {
            border-collapse: collapse;
        }


    </style>
@endsection

@section('content')

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Dashboard Pelanggan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="p-6 rounded-md">
                <div class="bg-dark text-white p-6 rounded-md">

                <p class="text-white">Selamat datang, <span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold"> {{ auth()->user()->name }}</span>!</p>

                {{-- Ubah kelas div di bawah ini ke 'container-buttons' --}}
                <div class="container-buttons">
                    <a href="{{ route('vehicles.index') }}"
                       class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Cari Kendaraan
                    </a>

                    <form method="POST" action="{{ route('checkout') }}" class="inline-block">
                        @csrf
                        <button type="submit"
                                class="inline bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Checkout
                        </button>
                    </form>
                </div>

                <br> <br>
                <h3><span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold">Status Pembayaran</span></h3>
                
                <table class="table border-0">
                <thead style="background-color: #00ffae; font-weight: bold;">
                    <tr>
                        <th>ID</th>
                        <th>Mobil</th>
                        <th>Harga</th>
                        <th>Tanggal Mulai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                        <tr>
                            <td>ID</td>
                            <td>kendaraan</td>
                            <td>harga</td>
                            <td>tanggal mulai</td>
                            <td>pending</td>
                        </tr>
                </tbody>
                </table>

                <br>
                <h3><span style="color:#00ffae; text-shadow: 0 0 5px rgba(0,255,174,0.6);" class="fw-bold">Riwayat Rental</span></h3>

                <table class="table border-0">
                <thead style="background-color: #00ffae; font-weight: bold;">
                    <tr>
                        <th>ID</th>
                        <th>Mobil</th>
                        <th>Harga</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                        <tr>
                            <td>ID</td>
                            <td>kendaraan</td>
                            <td>harga</td>
                            <td>tanggal mulai</td>
                            <td>tanggal akhir</td>
                        </tr>

                        <tr>
                            <td>ID</td>
                            <td>kendaraan</td>
                            <td>harga</td>
                            <td>tanggal mulai</td>
                            <td>tanggal akhir</td>
                        </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection