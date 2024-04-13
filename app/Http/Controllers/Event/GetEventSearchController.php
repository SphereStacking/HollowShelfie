<?php

namespace App\Http\Controllers\Event;

use App\Enums\EventStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Models\Category;
use App\Models\InstanceType;
use App\Params\EventSearchParams;
use App\Services\EventMeilisearchService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GetEventSearchController extends Controller
{
    public function __construct(
        private readonly EventMeilisearchService $eventMeilisearchService,
        private readonly TagService $tagService,
    ) {
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
                'trendTags' => fn () => $this->tagService->getTrendTagNames(),
                'events' => new EventsPaginatedJsonResource(
                    $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
                ),
                'categories' => fn () => Category::all(),
                'instanceTypes' => fn () => InstanceType::query()->select('name')->get(),
                'statuses' => fn () => EventStatus::PUBLISHED_STATUSES,
            ]
        );
    }
}
