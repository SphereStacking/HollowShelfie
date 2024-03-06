<?php

namespace App\Http\Controllers\SingleSignOn;

use App\Http\Controllers\Controller;
use App\Services\SocialAccountService;

class RedirectToProviderController extends Controller
{
    protected $socialAccountService;

    public function __construct(
        SocialAccountService $socialAccountService,
    ) {
        $this->socialAccountService = $socialAccountService;
    }

    public function __invoke($provider)
    {
        return $this->socialAccountService->redirectToProvider($provider);
    }
}
