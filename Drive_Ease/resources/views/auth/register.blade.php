<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Display general errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- role --}}
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select name="role" id="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="toggleFields()">
                <option value="pelanggan">Pelanggan</option>
                <option value="rental">Rental</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Pelanggan Fields -->
        <div id="pelanggan-fields" class="mt-4">
            <!-- ID Card -->
            <div class="mt-4">
                <x-input-label for="id_card" :value="__('ID Card Number')" />
                <x-text-input id="id_card" class="block mt-1 w-full" type="text" name="id_card" :value="old('id_card')" />
                <x-input-error :messages="$errors->get('id_card')" class="mt-2" />
            </div>

            <!-- Driver License -->
            <div class="mt-4">
                <x-input-label for="driver_license" :value="__('Driver License Number')" />
                <x-text-input id="driver_license" class="block mt-1 w-full" type="text" name="driver_license" :value="old('driver_license')" />
                <x-input-error :messages="$errors->get('driver_license')" class="mt-2" />
            </div>
        </div>

        <!-- Rental Fields -->
        <div id="rental-fields" class="mt-4" style="display: none;">
            <!-- Company Name -->
            <div class="mt-4">
                <x-input-label for="company_name" :value="__('Company Name')" />
                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>

            <!-- Company Address -->
            <div class="mt-4">
                <x-input-label for="company_address" :value="__('Company Address')" />
                <x-text-input id="company_address" class="block mt-1 w-full" type="text" name="company_address" :value="old('company_address')" />
                <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
            </div>

            <!-- Business License -->
            <div class="mt-4">
                <x-input-label for="business_license" :value="__('Business License Number')" />
                <x-text-input id="business_license" class="block mt-1 w-full" type="text" name="business_license" :value="old('business_license')" />
                <x-input-error :messages="$errors->get('business_license')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            const pelangganFields = document.getElementById('pelanggan-fields');
            const rentalFields = document.getElementById('rental-fields');

            if (role === 'pelanggan') {
                pelangganFields.style.display = 'block';
                rentalFields.style.display = 'none';
                document.getElementById('id_card').required = true;
                document.getElementById('driver_license').required = true;
                document.getElementById('company_name').required = false;
                document.getElementById('company_address').required = false;
                document.getElementById('business_license').required = false;
            } else if (role === 'rental') {
                pelangganFields.style.display = 'none';
                rentalFields.style.display = 'block';
                document.getElementById('id_card').required = false;
                document.getElementById('driver_license').required = false;
                document.getElementById('company_name').required = true;
                document.getElementById('company_address').required = true;
                document.getElementById('business_license').required = true;
            }
        }

        // Call on page load
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
</x-guest-layout>
