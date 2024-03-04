<?php

namespace App\Http\Controllers\EventSearch;

use Inertia\Inertia;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Models\InstanceType;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Params\EventSearchParams;
use App\Http\Controllers\Controller;
use App\Services\EventMeilisearchService;
use App\Http\Resources\EventListJsonResource;

class GetEventSearchController extends Controller
{
    protected $eventMeilisearchService;
    protected $tagService;

    public function __construct(
        EventMeilisearchService  $eventMeilisearchService,
        TagService $tagService
    ) {
        $this->eventMeilisearchService = $eventMeilisearchService;
        $this->tagService = $tagService;
    }

    public function __invoke(Request $request)
    {
        $EventSearchParams = new EventSearchParams(
            $request->input('t', null),
            $request->input('q', null),
            $request->input('paginate', null),
            $request->input('o', null),
        );
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
}
