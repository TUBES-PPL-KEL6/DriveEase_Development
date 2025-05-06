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

        <form method="POST" action="{{ route('payment_history.store') }}" class="mb-3 bg-light p-3 rounded-3 shadow-sm">
            @csrf
            {{-- <div class="mb-3">
                <!-- Automatically fill the username with the logged-in user's name -->
                <input type="text" name="username" value="{{ auth()->user()->name }}" readonly
                    class="form-control form-control-lg"    >
            </div> --}}
            <div class="mb-3 d-flex flex-column">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" value="{{ auth()->user()->name }}" readonly class="form-input">
            </div>

            <div class="mb-3">
                <label for="car" class="form-label">Mobil</label>
                <select name="car" id="car" class="form-select" placeholder="Pilih Mobil">
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 d-flex flex-column">
                <label for="price" class="form-label">Harga</label>
                <input type="number" name="price" placeholder="Harga" step="0.01" required class="form-input" dusk='harga-input'>
            </div>

            <button type="submit" class="btn btn-primary" dusk="checkout-submit-button">Submit</button>
        </form>

    </div>
</x-app-layout>
