<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class ProviderController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update user with Google info if they already exist
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'role' => 'siswa', // Default role for new users via Google
                    'password' => null, // Password is null for OAuth users
                ]);
            }

            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'bendahara') {
                return redirect()->route('bendahara.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }

        } catch (Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Terjadi kesalahan saat login dengan Google: ' . $e->getMessage()]);
        }
    }
}
