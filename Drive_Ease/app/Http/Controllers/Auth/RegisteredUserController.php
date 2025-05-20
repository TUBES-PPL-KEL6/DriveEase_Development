<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            Log::info('Starting user registration process', ['email' => $request->email]);

            $role = $request->input('role');

            $rules = [
                'role' => ['required', 'in:pelanggan,rental'],
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:20'],
                'address' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];

            if ($role === 'rental') {
                $rules['company_name'] = ['required', 'string', 'max:255'];
                $rules['company_address'] = ['required', 'string', 'max:255'];
                $rules['business_license'] = ['required', 'string', 'max:50'];
            } elseif ($role === 'pelanggan') {
                $rules['id_card'] = ['required', 'string', 'max:20'];
                $rules['driver_license'] = ['required', 'string', 'max:20'];
            }

            $validated = $request->validate($rules);

            $userData = [
                'role' => $validated['role'],
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'password' => Hash::make($validated['password']),
            ];

            if ($role === 'rental') {
                $userData['company_name'] = $validated['company_name'];
                $userData['company_address'] = $validated['company_address'];
                $userData['business_license'] = $validated['business_license'];
            } elseif ($role === 'pelanggan') {
                $userData['id_card'] = $validated['id_card'];
                $userData['driver_license'] = $validated['driver_license'];
            }

            $user = User::create($userData);

            Log::info('User created successfully', ['user_id' => $user->id]);

            event(new Registered($user));

            Auth::login($user);

            Log::info('User logged in and redirecting to dashboard');

            return redirect()->route('dashboard.redirect');

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);

            return back()->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }
}
