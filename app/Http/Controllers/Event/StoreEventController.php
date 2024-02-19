<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Models\InstanceType;
use App\Services\EventService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\InstanceTypeResource;

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
