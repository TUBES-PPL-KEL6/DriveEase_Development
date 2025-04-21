
<img src="{{ asset('images/qrcode.png') }}" alt="Example Image" width="200">

<br>
<a href="{{ route('checkout.return') }}">
    <button>Return to Dashboard</button>
</a>



<h2>Checkout Pemesanan</h2>

@if(session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('payment_history.store') }}">
    @csrf
    <div>
        <!-- Automatically fill the username with the logged-in user's name -->
        <input type="text" name="username" value="{{ auth()->user()->name }}" readonly>
    </div>
    <div>
        <input type="text" name="car" placeholder="Car" required>
    </div>
    <div>
        <input type="number" name="price" placeholder="Price" step="0.01" required>
    </div>
    <button type="submit">Submit</button>
</form>



