<?php

namespace App\Services;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialAccountService
{
    public function redirectToProvider($provider)
    {
        $allowedProviders = ['google', 'discord'];

        if (!in_array($provider, $allowedProviders)) {
            // プロバイダーが許可リストにない場合の処理
            return redirect()->back()->with('error', '不正なプロバイダーです。');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function createOrGetUser($provider)
    {
        $extUser = Socialite::driver($provider)->user();

        $user = User::firstOrCreate([
            'email' => $extUser->getEmail()
        ], [
            'name' => $extUser->getName(),
            'password' => Hash::make(Str::random(24))
        ]);

        $user->social_accounts()->firstOrCreate([
            'provider' => $provider,
            'provider_id' => $extUser->getId()
        ]);

        return $user;
    }
}
