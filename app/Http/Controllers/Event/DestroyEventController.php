<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Services\EventService;

class DestroyEventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke($alias)
    {
        $this->eventService->deleteEvent($alias);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'イベントを削除しました。',
        ]);
    }
}
