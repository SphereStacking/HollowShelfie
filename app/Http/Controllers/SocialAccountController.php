<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SocialAccountService;

class SocialAccountController extends Controller
{
    protected $socialAccountService;

    public function __construct(SocialAccountService $socialAccountService)
    {
        $this->socialAccountService = $socialAccountService;
    }

    public function redirectToProvider($provider)
    {
        return $this->socialAccountService->redirectToProvider($provider);
    }

    public function handleProviderCallback($provider)
    {
        $user = $this->socialAccountService->createOrGetUser($provider);
        if (!$user) {
            // ユーザーがnullの場合のエラーハンドリング
            return redirect()->route('login')->with('error', 'Failed to authenticate with the social account.');
        }

        Auth::login($user, true);

        return Inertia::render('Dashboard', []);
    }
}
