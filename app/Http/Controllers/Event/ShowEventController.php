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
    private $eventService;

    private $tagService;

    public function __construct(EventService $eventService, TagService $tagService)
    {
        $this->eventService = $eventService;
        $this->tagService = $tagService;
    }

    public function __invoke($alias): Response
    {
        return Inertia::render('Event/Show', [
            'event' => new EventShowJsonResource($this->eventService->getEventDetailByAlias($alias)),
            'trendTags' => $this->tagService->getTrendTagNames(),
        ]);
    }
}
