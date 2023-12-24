<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Resources\UserPublicProfileJsonResource;

class WelcomeController extends Controller
{
    protected $userService;

    public function __construct(
        UserService $userService,
    ) {
        $this->userService = $userService;
    }

    public function welcome()
    {
        return Inertia::render('Welcome', [
            'user' => new UserPublicProfileJsonResource(
                $this->userService->getPublishProfile(1),
            ),
        ]);
    }
}
