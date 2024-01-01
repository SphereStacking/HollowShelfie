<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Models\InstanceType;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Params\EventSearchParams;
use Illuminate\Support\Facades\DB;
use Meilisearch\Endpoints\Indexes;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SearchRequest;
use App\Services\EventSearchService;
use App\Services\EventMeilisearchService;
use App\Http\Resources\EventListJsonResource;

class SearchController extends Controller
{
    protected $eventService;
    protected $eventSearchService;
    protected $eventMeilisearchService;
    protected $tagService;

    public function __construct(
        EventService $eventService,
        EventSearchService $eventSearchService,
        EventMeilisearchService  $eventMeilisearchService,
        TagService $tagService
    ) {
        $this->eventService = $eventService;
        $this->eventSearchService = $eventSearchService;
        $this->eventMeilisearchService = $eventMeilisearchService;
        $this->tagService = $tagService;
    }


    public function event(SearchRequest $request)
    {
        $EventSearchParams = new EventSearchParams(
            $request->input('t', null),
            $request->input('q', null),
            $request->input('paginate', null),
            $request->input('o', null),
        );
        Log::debug($EventSearchParams);
        return Inertia::render(
            'Search/Event',
            [
                'trendTags' => $this->tagService->getTrendTagNames(),
                'events' => new EventListJsonResource(
                    $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
                ),
                'categories' =>  Category::all(),
                'instanceTypes' => InstanceType::all()->pluck('name'),
                'statuses' =>  EventStatus::getPermittedStatusesForListSearch(),
            ]
        );
    }
    public function user(SearchRequest $request)
    {
        $EventSearchParams = new EventSearchParams(
            $request->input('t', null),
            $request->input('q', null),
            $request->input('paginate', null),
            $request->input('o', null),
        );


        return Inertia::render(
            'Search/Performer',
            [
                'trendTags' => $this->tagService->getTrendTagNames(),
                'events' => new EventListJsonResource(
                    $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
                ),
                'categories' =>  Category::all(),
                'instanceTypes' => InstanceType::all()->pluck('name'),
                'statuses' =>  EventStatus::getPermittedStatusesForListSearch(),
            ]
        );
    }
}
