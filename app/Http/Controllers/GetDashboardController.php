<?php

namespace App\Http\Controllers;

use App\Services\EventBookmarkService;
use App\Services\EventGoodService;
use App\Services\EventService;
use App\Services\UserService;
use Inertia\Inertia;

class GetDashboardController extends Controller
{
    protected $eventService;

    protected $eventMeilisearchService;

    protected $tagService;

    protected $categoryService;

    protected $eventBookmarkService;

    protected $eventGoodService;

    protected $userService;

    public function __construct(
        EventService $eventService,
        EventBookmarkService $eventBookmarkService,
        EventGoodService $eventGoodService,
        UserService $userService
    ) {
        $this->eventService = $eventService;
        $this->eventBookmarkService = $eventBookmarkService;
        $this->eventGoodService = $eventGoodService;
        $this->userService = $userService;
    }

    public function __invoke()
    {
        return Inertia::render(
            'Dashboard/Index',
            ['counts' => [
                'bookmark' => [
                    'total' => $this->eventBookmarkService->getBookmarkedEventsCountByUser(auth()->user()),
                    'statues' => $this->eventBookmarkService->getBookmarkedEventsCountByUserForAllStatuses(auth()->user()),
                ],
                'good' => $this->eventGoodService->getGoodEventsByUser(auth()->user())->count(),
                'follow' => $this->userService->getFollowCount(auth()->user()),
                'follower' => $this->userService->getFollowerCount(auth()->user()),
            ],
            ]
        );
    }
}
