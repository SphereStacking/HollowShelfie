<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Params\EventSearchParams;
use App\Services\EventMeilisearchService;
use App\Services\TagService;

class GetUserSearchController extends Controller
{
    protected $eventMeilisearchService;

    protected $tagService;

    public function __construct(
        EventMeilisearchService $eventMeilisearchService,
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
        Log::debug($EventSearchParams);

        return Inertia::render(
            'Search/Performer',
            [
                'trendTags' => $this->tagService->getTrendTagNames(),
                'events' => new EventsPaginatedJsonResource(
                    $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
                ),
                'categories' => Category::all(),
                'instanceTypes' => InstanceType::all()->pluck('name'),
                'statuses' => EventStatus::PUBLIC_SEARCH_STATUSES,
            ]
        );
    }
}
