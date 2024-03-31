<?php

namespace App\Http\Controllers\EventBookmark;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Services\EventBookmarkService;
use Illuminate\Support\Facades\Auth;

class StoreBookmarkController extends Controller
{
    protected $eventBookmarkService;

    public function __construct(EventBookmarkService $eventBookmarkService)
    {
        $this->eventBookmarkService = $eventBookmarkService;
    }

    public function __invoke(Event $event)
    {
        $user = Auth::user();
        // イベントに「ブックマーク」を追加
        User::find($user->id)->bookmark_events()->attach($event->id);
        $this->eventBookmarkService->attachEvent($user, $event);

        return redirect()->back()->with([
            'response' => [
                'status' => 'success',
                'message' => 'イベントをブックマークしました。',
            ],
        ]);
    }
}
