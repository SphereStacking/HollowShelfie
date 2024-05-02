<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Services\UserService;
use App\Services\EventService;
use App\Services\GoogleFormsService;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\EventsJsonResource;
use App\Http\Resources\FeedbacksJsonResource;

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
            'developer' => config('developers.owner'),
            'events' => new EventsJsonResource($this->eventService->getPublicRandomEvents(15, [EventStatus::ONGOING])),
            'eventCount' => fn () => Event::count(),
            'userCount' => fn () => User::count(),
            'feedbacks' => fn () => new FeedbacksJsonResource($this->googleFormsService->getFormResponses(config('external_services.issue_forms.feedback.id'))),
            'sponsors' => fn () => config('sponsors.users'),
            'images' => fn () => [
                'ghost' => Storage::disk('public')->url('images/microsoft-teams/ghost_120x120.png'),
                'cracker' => Storage::disk('public')->url('images/microsoft-teams/cracker_120x120.png'),
                'smiling_face' => Storage::disk('public')->url('images/microsoft-teams/smiling_face_120x120.png'),
            ],
        ]);
    }
}
