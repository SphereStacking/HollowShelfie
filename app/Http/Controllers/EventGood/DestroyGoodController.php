<?php

namespace App\Http\Controllers\EventGood;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\EventGoodService;
use Illuminate\Support\Facades\Redirect;

class DestroyGoodController extends Controller
{
    protected $eventGoodService;

    public function __construct(EventGoodService $eventGoodService)
    {
        $this->eventGoodService = $eventGoodService;
    }

    public function __invoke(Event $event)
    {
        $user = Auth::user();
        $this->eventGoodService->detachEvent($user, $event);
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'イベントのいいねを取り消しました。'
        ]);
    }
}
