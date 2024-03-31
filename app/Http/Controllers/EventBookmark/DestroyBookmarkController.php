<?php

namespace App\Http\Controllers\EventBookmark;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\EventBookmarkService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DestroyBookmarkController extends Controller
{
    protected $eventBookmarkService;

    public function __construct(EventBookmarkService $eventBookmarkService)
    {
        $this->eventBookmarkService = $eventBookmarkService;
    }

    public function __invoke(Event $event)
    {
        $user = Auth::user();
        $this->eventBookmarkService->detachEvent($user, $event);

        return Redirect::back()->with([
            'status' => 'success',
            'message' => 'イベントのブックマークを取り消しました。',
        ]);
    }
}
