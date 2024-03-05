<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\TagService;
use App\Services\EventService;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Http\Resources\EventShowJsonResource;

class ShowEventController extends Controller
{
    private $eventService;
    private $tagService;

    public function __construct(EventService $eventService, TagService $tagService)
    {
        $this->eventService = $eventService;
        $this->tagService = $tagService;
    }

    public function __invoke($id): Response
    {
        return Inertia::render('Event/Show', [
            'event' => new EventShowJsonResource($this->eventService->getShowEvent($id)),
            'trendTags' => $this->tagService->getTrendTagNames()
        ]);
    }
}
