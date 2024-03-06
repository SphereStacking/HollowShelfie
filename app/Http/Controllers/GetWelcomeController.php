<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Resources\UserPublicProfileJsonResource;
use App\Models\User;

class GetWelcomeController extends Controller
{
    protected $userService;

    public function __construct(
        UserService $userService,
    ) {
        $this->userService = $userService;
    }

    public function __invoke()
    {
        return Inertia::render('Welcome', [
            'user' => new UserPublicProfileJsonResource(
                $this->userService->preloadProfileData(User::find(1)),
            ),
        ]);
    }
}
