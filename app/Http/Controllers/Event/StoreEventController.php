<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Services\EventService;

class StoreEventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(EventStoreRequest $request)
    {
        $attributes = $request->getAttributes();
        $this->eventService->storeEvent($attributes);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'イベントを登録しました。',
        ]);
    }
}
