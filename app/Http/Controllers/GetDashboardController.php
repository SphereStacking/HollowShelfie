<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Services\UserService;
use App\Services\EventService;
use App\Services\EventGoodService;
use App\Services\EventBookmarkService;

class GetDashboardController extends Controller
{

    public function __construct(
        readonly private EventService $eventService,
        readonly private EventBookmarkService $eventBookmarkService,
        readonly private EventGoodService $eventGoodService,
        readonly private UserService $userService
    ) {
    }

    public function __invoke()
    {
        return Inertia::render(
            'Dashboard/Index',
            [
                'counts' => [
                    'bookmark' => $this->eventBookmarkService->getBookmarkedEventsCountByUser(auth()->user()),
                    'good' => $this->eventGoodService->getGoodEventsByUser(auth()->user())->count(),
                    'follow' => $this->userService->getFollowCount(auth()->user()),
                    'follower' => $this->userService->getFollowerCount(auth()->user()),
                    'eventDraft' => $this->eventService->getDraftEventCountByUser(auth()->user()),
                    'eventPublished' => $this->eventService->getPublishedEventCountByUser(auth()->user()),
                ],
            ]
        );
    }
}
