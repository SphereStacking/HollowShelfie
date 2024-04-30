<?php

namespace App\Http\Controllers\Event;

use DateTimeZone;
use App\Services\EventService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventShowJsonResource;
use App\Exceptions\CannotOperateEventException;

class UpdateEventController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
    }

    public function __invoke(EventUpdateRequest $request, $alias)
    {
        $event = $this->eventService->getEventDetailByAlias($alias);
        if (! $event->canUserOperate(Auth::user())) {
            throw new CannotOperateEventException();
        }
        $attributes = $request->getAttributes();
        $event = $this->eventService->updateEventByAlias($alias, $attributes);

        return redirect()->back()->with([
            'response' => [
                'status' => 'success',
                'message' => 'イベントを更新しました。',
                'event' => new EventShowJsonResource($event),
            ],
        ]);
    }
}
