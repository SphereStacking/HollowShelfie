<?php

namespace App\Http\Controllers\EventGood;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\EventGoodService;
use Illuminate\Support\Facades\Auth;

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
            'message' => 'イベントのいいねを取り消しました。',
        ]);
    }
}
