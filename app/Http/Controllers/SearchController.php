<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Models\InstanceType;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Params\EventSearchParams;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SearchRequest;
use App\Services\EventSearchService;
use App\Http\Resources\EventListJsonResource;

class SearchController extends Controller
{
    protected $eventService;
    protected $eventSearchService;

    public function __construct(
        EventService $eventService,
        EventSearchService $eventSearchService
    ) {
        $this->eventService = $eventService;
        $this->eventSearchService = $eventSearchService;
    }

    public function index(SearchRequest $request)
    {
        $EventSearchParams = new EventSearchParams(
            $request->input('t', ''),
            $request->input('q', []),
            $request->input('paginate', 64),
            $request->input('o', 'new'),
        );
        return Inertia::render(
            'Search/Index',
            [
                'trendTags' => $this->eventService->getTrendTagNames(),
                'events' => new EventListJsonResource(
                    $this->eventSearchService->getPublishedEventSearch($EventSearchParams)
                ),
                'categories' =>  Category::all(),
                'instanceTypes' => InstanceType::all()->pluck('name'),
                'statuses' =>  EventStatus::getPermittedStatusesForListSearch(),
            ]
        );
    }
}
