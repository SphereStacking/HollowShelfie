<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use App\Models\Event;
use Inertia\Response;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Models\InstanceType;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\CategoryResource;
use App\Services\EventMeilisearchService;
use App\Http\Resources\InstanceTypeResource;
use App\Http\Resources\EventListJsonResource;
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
