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
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Services\DynamicSearch\Meilisearch\SearchParams;
use App\Services\DynamicSearch\Meilisearch\Event\EventMeilisearchService;

class GetManageEventController extends Controller
{
    public function __construct(
        private readonly EventMeilisearchService $eventMeilisearchService,
        private readonly TagService $tagService
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $eventSearchParams = new SearchParams(
            $request->input('t', null),
            $request->input('q', null),
            $request->input('paginate', 12),
            $request->input('o', 'created_at'),
            $request->input('d', null),
        );

        $events = $this->eventMeilisearchService->searchManageableEvents($eventSearchParams);

        return Inertia::render('Event/EventManage', [
            'events' => new EventsPaginatedJsonResource($events),
            'categories' => fn () => Category::all(),
            'instanceTypes' => fn () => InstanceType::query()->pluck('name'),
            'statuses' => fn () => Event::canManagerSearchStatus(),
            'trendTags' => fn () => $this->tagService->getTrendTagNames(),
        ]);
    }
}
