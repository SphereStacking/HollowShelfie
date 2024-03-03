<?php

namespace App\Http\Controllers\EventBookmark;

use App\Models\User;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\EventBookmarkService;

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
            'response'=> [
                'status' => 'success',
                'message' => 'イベントをブックマークしました。'
            ]
        ]);
    }
}
