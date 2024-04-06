<?php

namespace App\Http\Controllers\EventBookmark;

use App\Services\EventService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\EventBookmarkService;

class StoreBookmarkController extends Controller
{
    protected $eventService;
    protected $eventBookmarkService;

    public function __construct(EventService $eventService,EventBookmarkService $eventBookmarkService)
    {
        $this->eventBookmarkService = $eventBookmarkService;
        $this->eventService = $eventService;
    }

    public function __invoke($alias)
    {
        // イベントに「ブックマーク」を追加
        $event = $this->eventService->getEventByAlias($alias);
        $this->eventBookmarkService->attachEvent(Auth::user(), $event);

        return redirect()->back()->with([
            'response' => [
                'status' => 'success',
                'message' => 'イベントをブックマークしました。',
            ],
        ]);
    }
}
