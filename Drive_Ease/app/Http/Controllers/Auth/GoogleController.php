<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user exists
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'username' => explode('@', $googleUser->email)[0], // Use email prefix as username
                    'password' => bcrypt(str_random(16)), // Random password
                    'role' => 'pelanggan', // Default role
                ]);
            }

            // Login user
            Auth::login($user);

            return redirect()->route('dashboard.redirect');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed. Please try again.');
        }
    }
} 