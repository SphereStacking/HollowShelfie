<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventEditJsonResource;
use App\Services\EventService;

class UpdateEventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(EventUpdateRequest $request, $id)
    {
        $attributes = $request->getAttributes();
        $event = $this->eventService->updateEvent($id, $attributes);

        return redirect()->back()->with([
            'response' => [
                'status' => 'success',
                'message' => 'イベントを更新しました。',
                'event' => new EventEditJsonResource($event),
            ],
        ]);
    }
}
