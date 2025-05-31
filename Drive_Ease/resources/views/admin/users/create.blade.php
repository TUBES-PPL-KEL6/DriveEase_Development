@extends('layouts.app')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar')
    
    <div class="flex-grow-1 p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h1>

            <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
                        <option value="rental" {{ (old('role', $user->role ?? '') == 'rental') ? 'selected' : '' }}>Rental</option>
                        <option value="customer" {{ (old('role', $user->role ?? '') == 'customer') ? 'selected' : '' }}>Customer</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if(!isset($user))
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                @endif

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Simpan' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 