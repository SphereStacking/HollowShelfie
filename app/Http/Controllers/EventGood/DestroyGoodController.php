<?php

namespace App\Http\Controllers\EventGood;

use App\Services\EventService;
use App\Services\EventGoodService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DestroyGoodController extends Controller
{
    protected $eventService;
    protected $eventGoodService;

    public function __construct(EventService $eventService,EventGoodService $eventGoodService)
    {
        $this->eventService = $eventService;
        $this->eventGoodService = $eventGoodService;
    }

    public function __invoke($alias)
    {
        $event = $this->eventService->getEventByAlias($alias);
        $this->eventGoodService->detachEvent(Auth::user(), $event);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'イベントのいいねを取り消しました。',
        ]);
    }
}
