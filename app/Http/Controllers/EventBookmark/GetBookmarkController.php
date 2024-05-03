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

        $user = auth()->user();
        $bookmarkedEvents = $user->bookmark_events()->paginate(12);

        return Inertia::render(
            'Dashboard/Bookmark',
            [
                'events' => new EventsPaginatedJsonResource($bookmarkedEvents),
            ]
        );
    }
}
