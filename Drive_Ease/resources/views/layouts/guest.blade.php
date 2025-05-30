<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Sesuaikan warna background untuk guest layout */
            body {
                background-color: #f0f4f8; /* Light blue-gray background */
            }
            .bg-gray-100 { /* Untuk div min-h-screen */
                background-color: #f0f4f8; /* Sesuaikan agar konsisten */
            }
            .bg-white { /* Untuk card form login/register */
                background-color: #ffffff; /* Tetap putih */
                border-radius: 0.5rem; /* Tambahkan sedikit border-radius */
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Tambahkan shadow */
            }
            .text-gray-900 {
                color: #334155; /* Ubah warna teks default menjadi abu-abu gelap */
            }
            .text-gray-500 { /* Untuk application logo */
                color: #64748b; /* Warna abu-abu yang lebih lembut */
            }
        </style>
    </head>
    <body class="font-sans antialiased"> {{-- Hapus text-gray-900 di sini karena akan diatur di style --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}

            </div>
        </div>
    </body>
</html>