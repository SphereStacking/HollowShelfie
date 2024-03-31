<?php

namespace App\Http\Controllers\SingleSignOn;

use App\Http\Controllers\Controller;
use App\Services\SocialAccountService;
use Illuminate\Support\Facades\Auth;

class ProviderCallbackController extends Controller
{
    protected $socialAccountService;

    public function __construct(
        SocialAccountService $socialAccountService,
    ) {
        $this->socialAccountService = $socialAccountService;
    }

    public function __invoke($provider)
    {
        $result = $this->socialAccountService->createOrGetUser($provider);

        if (! $result['user']) {
            return redirect()->route('login')->with('error', 'Failed to authenticate with the social account.');
        }

        Auth::login($result['user'], true);

        return $result['isNew']
            ? redirect()->route('welcome')
            : redirect()->route('home');
    }
}
