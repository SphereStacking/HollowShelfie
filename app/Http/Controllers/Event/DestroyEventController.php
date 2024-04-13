<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Services\EventService;

class DestroyEventController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
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
