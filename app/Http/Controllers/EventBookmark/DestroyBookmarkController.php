<?php

namespace App\Http\Controllers\EventBookmark;

use App\Services\EventService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\EventBookmarkService;
use Illuminate\Support\Facades\Redirect;

class DestroyBookmarkController extends Controller
{

    public function __construct(
        private EventService $eventService,
        private EventBookmarkService $eventBookmarkService
    ) {}

    public function __invoke($alias)
    {
        $event = $this->eventService->getEventByAlias($alias);
        $this->eventBookmarkService->detachEvent(Auth::user(), $event);

        return Redirect::back()->with([
            'status' => 'success',
            'message' => 'イベントのブックマークを取り消しました。',
        ]);
    }
}
