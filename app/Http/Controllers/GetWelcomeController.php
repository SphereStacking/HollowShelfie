<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Enums\EventStatus;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\EventService;
use App\Http\Resources\EventsJsonResource;
use App\Http\Resources\UserPublicProfileJsonResource;

class GetWelcomeController extends Controller
{
    protected $userService;
    protected $eventService;

    public function __construct(
        UserService $userService,
        EventService $eventService,
    ) {
        $this->userService = $userService;
        $this->eventService = $eventService;
    }

    public function __invoke()
    {
        return Inertia::render('Welcome', [
            'user' => new UserPublicProfileJsonResource(
                $this->userService->preloadProfileData(User::find(1)),
            ),
            'events' => new EventsJsonResource($this->eventService->getPublicRandomEvents(15, [EventStatus::ONGOING])),
        ]);
    }
}
