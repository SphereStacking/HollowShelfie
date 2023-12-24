<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Http\Resources\EventsJsonResource;

class HomeController extends Controller
{
    protected $eventService;

    public function __construct(
        EventService $eventService,
    ) {
        $this->eventService = $eventService;
    }

    public function index()
    {
        return Inertia::render(
            'Home',
            [
                'newEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('new')->take(12)->get()),
                'ongoingEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('ongoing')->take(12)->get()),
                'highlightEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('highlight')->take(12)->get()),
                'recentEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('recent')->take(12)->get()),
                'myBookmarkEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('mybookmark')->take(12)->get()),
            ]
        );
    }
}
