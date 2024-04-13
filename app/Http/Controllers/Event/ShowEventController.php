<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventShowJsonResource;
use App\Services\EventService;
use App\Services\TagService;
use Inertia\Inertia;
use Inertia\Response;

class ShowEventController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
        private readonly TagService $tagService
    ) {
    }

    public function __invoke($alias): Response
    {
        return Inertia::render('Event/Show', [
            'event' => new EventShowJsonResource($this->eventService->getEventDetailByAlias($alias)),
            'trendTags' => $this->tagService->getTrendTagNames(),
        ]);
    }
}
