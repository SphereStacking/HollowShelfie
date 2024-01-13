<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\EventBookmarkService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\EventListJsonResource;

class EventBookmarkController extends Controller
{
    protected $eventBookmarkService;

    public function __construct(EventBookmarkService $eventBookmarkService)
    {
        $this->eventBookmarkService = $eventBookmarkService;
    }

    public function bookmark()
    {
        return Inertia::render(
            'Dashboard/Bookmark',
            [
                'events' => new EventListJsonResource(
                    $this->eventBookmarkService->getBookmarkedEventsByUser(auth()->user())
                ),
            ]
        );
    }

    public function store(Event $event)
    {
        $user = Auth::user();
        // イベントに「ブックマーク」を追加
        User::find($user->id)->bookmark_events()->attach($event->id);
        $this->eventBookmarkService->attachEvent($user, $event);
        return Redirect::back()->with([
            'status' => 'success',
            'message' => 'イベントをブックマークしました。'
        ]);
    }

    public function destroy(Event $event)
    {
        $user = Auth::user();
        // ブックマークを取り消す
        $this->eventBookmarkService->detachEvent($user, $event);
        return Redirect::back()->with([
            'status' => 'success',
            'message' => 'イベントのブックマークを取り消しました。'
        ]);
    }
}
