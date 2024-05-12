<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Enums\EventStatus;
use App\Services\TagService;
use App\Services\EventService;
use App\Services\CategoryService;
use App\Http\Resources\EventsJsonResource;
use App\Http\Resources\TagWithCountJsonResource;
use App\Http\Resources\CategoryWithCountJsonResource;
use App\Services\DynamicSearch\Meilisearch\SearchParams;
use App\Services\DynamicSearch\Meilisearch\Event\EventMeilisearchService;

class GetHomeController extends Controller
{
    protected $eventService;

    protected $eventMeilisearchService;

    protected $tagService;

    protected $categoryService;

    public function __construct(
        EventService $eventService,
        EventMeilisearchService $eventMeilisearchService,
        CategoryService $categoryService,
        TagService $tagService
    ) {
        $this->eventService = $eventService;
        $this->eventMeilisearchService = $eventMeilisearchService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    public function __invoke()
    {
        $newParams = new SearchParams(
            '',
            [],
            12,
            'new',
        );

        $ongoingParams = new SearchParams(
            '',
            [['include' => 'or', 'type' => 'status', 'value' => EventStatus::ONGOING->name]],
            12,
            null,
        );

        $recentParams = new SearchParams(
            '',
            [
                ['include' => 'not', 'type' => 'status', 'value' => EventStatus::ONGOING->name],
            ],
            12,
            null,
        );

        $ongoingEvents = $this->eventMeilisearchService
            ->getPublishedEventSearch($ongoingParams);
        $planningEventCount = $this->eventMeilisearchService
            ->getPublishedEventSearch($recentParams);
        $newEvents = $this->eventMeilisearchService
            ->getPublishedEventSearch($newParams);
        return Inertia::render(
            'Home',
            [
                'trendCategories' => fn () => new CategoryWithCountJsonResource($this->categoryService->getTrendCategories(10)),
                'trendTags' => fn () => new TagWithCountJsonResource($this->tagService->getTrendTag(10)),
                'ongoingEvents' => fn () => new EventsJsonResource($ongoingEvents),
                'ongoingEventsUrl' => fn () => route('event.search.index', [
                    't' => $ongoingParams->text,
                    'q' => $ongoingParams->queryParams,
                    'paginate' => $ongoingParams->getDefaultPaginate(),
                    'o' => $ongoingParams->order,
                ]),
                'planningEvents' => fn () => new EventsJsonResource($planningEventCount),
                'planningEventsUrl' => fn () => route('event.search.index', [
                    't' => $recentParams->text,
                    'q' => $recentParams->queryParams,
                    'paginate' => $recentParams->getDefaultPaginate(),
                    'o' => $recentParams->order,
                ]),

                'newEvents' => fn () => new EventsJsonResource($newEvents),
                'newEventsUrl' => fn () => route('event.search.index', [
                    't' => $newParams->text,
                    'q' => $newParams->queryParams,
                    'paginate' => $newParams->getDefaultPaginate(),
                    'o' => $newParams->order,
                ]),
            ]
        );
    }
}
