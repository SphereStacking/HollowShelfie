<?php

namespace App\Services;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * ソーシャルアカウントサービスクラス
 */
class SocialAccountService
{
    /**
     * プロバイダーへリダイレクト
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        $allowedProviders = ['google', 'discord'];

        if (!in_array($provider, $allowedProviders)) {
            // プロバイダーが許可リストにない場合の処理
            return redirect()->back()->with('error', '不正なプロバイダーです。');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * ユーザーを作成または取得
     *
     * @param string $provider
     * @return array
     */
    public function createOrGetUser($provider)
    {
        $extUser = Socialite::driver($provider)->user();
        $user = User::firstOrCreate(
            ['email' => $extUser->getEmail()],
            ['name' => $extUser->getName(), 'password' => Hash::make(Str::random(24))]
        );
        $isNew = $user->wasRecentlyCreated;
        return compact('user', 'isNew');
    }
}
