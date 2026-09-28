<?php

namespace App\Http\Controllers;

use App\Models\LinkedAccount;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CloudProviderController extends Controller
{
public function redirectToGoogle()
{
    return Socialite::driver('google')
        ->scopes([
            'https://www.googleapis.com/auth/drive',
            'email',
            'profile',
            'openid'
        ])
        ->with([
            'prompt' => 'select_account',
            'access_type' => 'offline',
            'response_type' => 'code'
        ])
        ->redirect();
}
    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
               dd('Google is trying to connect this email:', $socialUser->email);

            if (!Auth::check()) {
                return redirect('/login')->with('error', 'You must be logged in.');
            }

            if (!Auth::check()) {
                return redirect('/login')->with('error', 'You must be logged in.');
            }

            $linkedAccount = LinkedAccount::where('provider', 'google')
                ->where('provider_id', $socialUser->id)
                ->first();

            $tokenData = [
                'access_token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
                'expires_at' => now()->addSeconds($socialUser->expiresIn ?? 14400),
                'email' => $socialUser->email, // THIS SAVES THE EMAIL
            ];

            if ($linkedAccount) {
                $linkedAccount->update($tokenData);
            } else {
                LinkedAccount::create(array_merge([
                    'user_id' => Auth::id(),
                    'provider' => 'google',
                    'provider_id' => $socialUser->id,
                ], $tokenData));
            }

            return redirect()->route('dashboard')->with('success', 'Google connected successfully!');

        } catch (\Throwable $e) {
            return redirect()->route('dashboard')->with('error', 'Connection failed: ' . $e->getMessage());
        }
    }
}
