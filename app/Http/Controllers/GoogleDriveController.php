<?php

  namespace App\Http\Controllers;

use App\Models\LinkedAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleDriveController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/drive'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        // We use \Throwable here to catch ALL errors, not just Exceptions

        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user is logged in to our app
            if (!Auth::check()) {
                return redirect('/login')->with('error', 'You must be logged in to link accounts.');
            }

            $linkedAccount = LinkedAccount::where('provider', 'google')
                ->where('provider_id', $googleUser->id)
                ->first();

            if ($linkedAccount) {
                $linkedAccount->update([
                    'access_token' => $googleUser->token,
                    'refresh_token' => $googleUser->refreshToken,
                    'expires_at' => now()->addSeconds($googleUser->expiresIn ?? 3600), // Fallback to 1 hour if null
                ]);
            } else {
                LinkedAccount::create([
                    'user_id' => Auth::id(),
                    'provider' => 'google',
                    'provider_id' => $googleUser->id,
                    'access_token' => $googleUser->token,
                    'refresh_token' => $googleUser->refreshToken,
                    'expires_at' => now()->addSeconds($googleUser->expiresIn ?? 3600),
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Google Drive connected successfully!');

        } catch (\Throwable $e) {
            // This saves the error to storage/logs/laravel.log
            Log::error('Google OAuth Error: ' . $e->getMessage());

            return redirect()->route('dashboard')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
