<?php

namespace App\Http\Controllers\Event;

use App\Exceptions\CannotOperateEventException;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\EventEditJsonResource;
use App\Http\Resources\InstanceTypeResource;
use App\Models\Category;
use App\Models\InstanceType;
use App\Services\EventService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class GetEditEventController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
    }

    public function __invoke($alias): Response
    {
        $event = $this->eventService->getEventDetailByAlias($alias);
        if (! $event->canUserOperate(Auth::user())) {
            throw new CannotOperateEventException();
        }

        return Inertia::render('Event/Edit', [
            'categories' => fn () => CategoryResource::collection(Category::all()),
            'instanceTypes' => fn () => InstanceTypeResource::collection(InstanceType::all()),
            'event' => new EventEditJsonResource($event),
        ]);
    }
}
