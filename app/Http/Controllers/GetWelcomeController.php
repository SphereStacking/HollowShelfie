<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Http\Resources\EventsJsonResource;
use App\Http\Resources\FeedbacksJsonResource;
use App\Http\Resources\UserPublicProfileJsonResource;
use App\Models\Event;
use App\Models\User;
use App\Services\EventService;
use App\Services\GoogleFormsService;
use App\Services\UserService;
use Inertia\Inertia;

class GetWelcomeController extends Controller
{
    protected $userService;

    protected $eventService;

    protected $googleFormsService;

    public function __construct(
        UserService $userService,
        EventService $eventService,
        GoogleFormsService $googleFormsService,
    ) {
        $this->userService = $userService;
        $this->eventService = $eventService;
        $this->googleFormsService = $googleFormsService;
    }

    public function __invoke()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return Inertia::render('Welcome', [
            'user' => new UserPublicProfileJsonResource(
                $this->userService->preloadProfileData(User::find(1)),
            ),
            'events' => new EventsJsonResource($this->eventService->getPublicRandomEvents(15, [EventStatus::ONGOING])),
            'eventCount' => fn () => Event::count(),
            'userCount' => fn () => User::count(),
            'feedbacks' => fn () => new FeedbacksJsonResource($this->googleFormsService->getFormResponses(config('external_services.issue_forms.feedback.id'))),
            'sponsors' => fn () => config('sponsors.users'),
        ]);
    }
}
