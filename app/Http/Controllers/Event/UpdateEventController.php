<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventShowJsonResource;
use App\Services\EventService;

class UpdateEventController extends Controller
{
    public function __construct(
        private readonly EventService $eventService
    ) {}

    public function __invoke(EventUpdateRequest $request, $id)
    {
        $attributes = $request->getAttributes();
         $event = $this->eventService->updateEventByAlias($id, $attributes);
        return redirect()->back()->with([
            'response' => [
                'status' => 'success',
                'message' => 'イベントを更新しました。',
                'event' => new EventShowJsonResource($event),
            ],
        ]);
    }
}
