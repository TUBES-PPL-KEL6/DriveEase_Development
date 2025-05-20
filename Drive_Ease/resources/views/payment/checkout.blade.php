<x-app-layout>
    <x-slot name="header">
        <h1>Checkout Pemesanan</h1>
    </x-slot>


    <div class="container">
        <img src="{{ asset('images/qrcode.png') }}" alt="Example Image" width="200" class="mb-3">

        <a href="{{ route('checkout.return') }}" class="btn btn-primary mb-3">
            Return to Dashboard
        </a>

        @if (session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

<form method="POST" action="{{ route('payment_history.store') }}"> 
    @csrf
    <div class="mb-3 d-flex flex-column">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" value="{{ auth()->user()->name }}" readonly class="form-input">
    </div>

    <div class="mb-3">
        <label for="vehicles" class="form-label">Mobil</label>
        <select name="vehicles" id="vehicles" class="form-select" placeholder="Pilih Mobil">
            @foreach ($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3 d-flex flex-column">
        <label for="price" class="form-label">Harga</label>
        <input type="number" name="price" placeholder="Harga" step="0.01" required class="form-input">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>


    </div>
</x-app-layout>
