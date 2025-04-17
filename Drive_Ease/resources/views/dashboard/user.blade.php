<h1>Dashboard Pelanggan</h1>
<p>Selamat datang, {{ auth()->user()->name }}</p>

<form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
    @csrf
    <button type="submit">Logout</button>
</form>
