<?php

namespace App\Http\Controllers\EventBookmark;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Services\EventBookmarkService;
use App\Http\Resources\EventsPaginatedJsonResource;

class GetBookmarkController extends Controller
{
    protected $eventBookmarkService;

    public function __construct(EventBookmarkService $eventBookmarkService)
    {
        $this->eventBookmarkService = $eventBookmarkService;
    }

    public function __invoke()
    {
        return Inertia::render(
            'Dashboard/Bookmark',
            [
                'events' => new EventsPaginatedJsonResource(
                    $this->eventBookmarkService->getBookmarkedEventsByUser(auth()->user())
                ),
            ]
        );
    }
}
