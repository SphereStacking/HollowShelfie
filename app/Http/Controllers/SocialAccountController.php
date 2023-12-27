<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Services\SocialAccountService;
use App\Http\Resources\UserPublicProfileJsonResource;

class SocialAccountController extends Controller
{
    protected $socialAccountService;
    protected $userService;


    public function __construct(
        SocialAccountService $socialAccountService,
        UserService $userService,
    ) {
        $this->socialAccountService = $socialAccountService;
        $this->userService = $userService;
    }

    public function redirectToProvider($provider)
    {
        return $this->socialAccountService->redirectToProvider($provider);
    }

    public function handleProviderCallback($provider)
    {
        $result = $this->socialAccountService->createOrGetUser($provider);

        if (!$result['user']) {
            return redirect()->route('login')->with('error', 'Failed to authenticate with the social account.');
        }

        Auth::login($result['user'], true);

        return $result['isNew']
            ? redirect()->route('welcome')
            : redirect()->route('home');
    }
}
