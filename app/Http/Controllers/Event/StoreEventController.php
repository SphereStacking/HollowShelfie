<?php

namespace App\Http\Controllers\Event;

use App\Services\EventService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;

class StoreEventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(EventStoreRequest $request)
    {
        $attributes = $request->eventAttributes();
        $this->eventService->storeEvent($attributes);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'イベントを登録しました。'
        ]);
    }
}
