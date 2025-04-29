{{-- @if (session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
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

    <form method="POST" action="{{ route('checkout') }}" style="margin-top: 20px;">
        @csrf
        <button type="submit" class="btn btn-primary">checkout</button>
    </form>
</x-app-layout>
