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