@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Dashboard Admin</h1>
        <p class="text-lg text-gray-600 mb-6">
            Selamat datang, <span class="font-semibold text-blue-600">{{ auth()->user()->name }}</span>!
        </p>

        {{-- Daftar pengguna --}}
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Daftar Pengguna</h2>
        @livewire('admin.user-table')

        <hr class="my-6 border-gray-200">

        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <a href="{{ route('admin.payment.index') }}"
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 text-center font-semibold shadow-md">
                Lihat Semua Riwayat Pembayaran
            </a>
        </div>
    </div>
@endsection
