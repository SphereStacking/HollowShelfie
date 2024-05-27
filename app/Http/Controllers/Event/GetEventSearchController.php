<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use App\Models\Event;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Models\InstanceType;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagNamesJsonResource;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Http\Resources\InstanceTypeNamesJsonResource;
use App\Services\DynamicSearch\Meilisearch\SearchParams;
use App\Services\DynamicSearch\Meilisearch\Event\EventMeilisearchService;

class GetEventSearchController extends Controller
{
    public function __construct(
        private readonly EventMeilisearchService $eventMeilisearchService,
        private readonly TagService $tagService,
    ) {
    }

    public function __invoke(Request $request)
    {
        $EventSearchParams = new SearchParams(
            $request->input('t', null),
            $request->input('q', null),
            $request->input('paginate', null),
            $request->input('o', null),
        );

        return Inertia::render(
            'Event/Search',
            [
                'trendTags' => fn () => new TagNamesJsonResource($this->tagService->getTrendTag()),
                'events' => new EventsPaginatedJsonResource(
                    $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
                ),
                'categories' => fn () => Category::all(),
                'instanceTypes' => fn () => new InstanceTypeNamesJsonResource(InstanceType::all()),
                'statuses' => fn () => Event::canGeneralSearchStatus(),
            ]
        );
    }
}
