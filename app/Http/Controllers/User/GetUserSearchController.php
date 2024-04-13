<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Models\InstanceType;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Params\EventSearchParams;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\EventMeilisearchService;
use App\Http\Resources\EventsPaginatedJsonResource;

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

    public function __invoke(Request $request): Response
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
                'events' => new EventsPaginatedJsonResource(
                    $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
                ),
                'categories' => fn () => Category::all(),
                'instanceTypes' => fn () => InstanceType::query()->pluck('name'),
                'statuses' => fn () => EventStatus::PUBLIC_SEARCH_STATUSES,
            ]
        );
    }
}
