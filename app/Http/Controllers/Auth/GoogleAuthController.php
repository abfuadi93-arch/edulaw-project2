<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        abort_unless(
    config('services.google.enabled') &&
    config('services.google.client_id') &&
    config('services.google.client_secret'),
    404
);

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
    abort_unless(
    config('services.google.enabled') &&
    config('services.google.client_id') &&
    config('services.google.client_secret'),
    404
);

        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            return redirect('/admin/login')
                ->withErrors([
                    'email' => 'Akun Google ini belum terdaftar sebagai pengguna Edulaw Console.',
                ]);
        }

        Auth::login($user, remember: true);

        return redirect('/admin');
    }
}