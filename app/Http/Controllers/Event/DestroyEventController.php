<?php

namespace App\Http\Controllers\Event;

use App\Services\EventService;
use App\Http\Controllers\Controller;

class DestroyEventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke($id)
    {
        $this->eventService->deleteEvent($id);
        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'イベントを削除しました。'
        ]);
    }
}
