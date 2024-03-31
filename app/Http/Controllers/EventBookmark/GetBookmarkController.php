<?php

namespace App\Http\Controllers\EventBookmark;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Services\EventBookmarkService;
use Inertia\Inertia;

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
