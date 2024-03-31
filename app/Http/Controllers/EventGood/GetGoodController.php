<?php

namespace App\Http\Controllers\EventGood;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Services\EventGoodService;
use Inertia\Inertia;

class GetGoodController extends Controller
{
    protected $eventGoodService;

    public function __construct(EventGoodService $eventGoodService)
    {
        $this->eventGoodService = $eventGoodService;
    }

    public function __invoke()
    {
        return Inertia::render(
            'Dashboard/Good',
            [
                'events' => new EventsPaginatedJsonResource(
                    $this->eventGoodService->getGoodEventsByUser(auth()->user())
                ),
            ]
        );
    }
}
