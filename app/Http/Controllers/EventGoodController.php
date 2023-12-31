<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Services\EventGoodService;
use Illuminate\Support\Facades\Auth;

/**
 * イベントに対する「いいね」を管理するコントローラー
 */
class EventGoodController extends Controller
{
    protected $eventGoodService;

    public function __construct(EventGoodService $eventGoodService)
    {
        $this->eventGoodService = $eventGoodService;
    }

    /**
     * イベントに「いいね」を追加する
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Event $event)
    {
        $user = Auth::user();
        $this->eventGoodService->attachEvent($user, $event);
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'イベントにいいねしました。'
        ]);
    }

    /**
     * イベントの「いいね」を取り消す
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        $user = Auth::user();
        $this->eventGoodService->detachEvent($user, $event);
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'イベントのいいねを取り消しました。'
        ]);
    }
}
