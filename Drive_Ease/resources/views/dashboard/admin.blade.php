<<<<<<< Updated upstream
<h1>Dashboard Admin</h1>
<p>Selamat datang, {{ auth()->user()->name }}</p>

<form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
    @csrf
    <button type="submit">Logout</button>
</form>

<form method="GET" action="{{ route('payment.index') }}" style="margin-top: 20px;">
    @csrf
    <button type="submit">check all payment history</button>
</form>
=======
@extends('layouts.app')

@section('content')
    <h1>Selamat datang di dashboard</h1>
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, {{ auth()->user()->name }}</p>
    
    <!-- <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
        @csrf
        <button type="submit">Logout</button>
    </form> -->
    
    <form method="GET" action="{{ route('admin.payment.index') }}" style="margin-top: 20px;">
        @csrf
        <button type="submit" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">check all payment history</button>
    </form>
@endsection

>>>>>>> Stashed changes
