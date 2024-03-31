<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Http\Resources\CategoryWithCountJsonResource;
use App\Http\Resources\EventsJsonResource;
use App\Http\Resources\TagWithCountJsonResource;
use App\Params\EventSearchParams;
use App\Services\CategoryService;
use App\Services\EventMeilisearchService;
use App\Services\EventService;
use App\Services\TagService;
use Inertia\Inertia;

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
        $trendParams = new EventSearchParams(
            '',
            [],
            12,
            'new',
        );

        $newParams = new EventSearchParams(
            '',
            [],
            12,
            'new',
        );

        $ongoingParams = new EventSearchParams(
            '',
            [['include' => 'or', 'type' => 'status', 'value' => EventStatus::ONGOING->name]],
            12,
            null,
        );

        $recentParams = new EventSearchParams(
            '',
            [
                ['include' => 'not', 'type' => 'status', 'value' => EventStatus::ONGOING->name],
            ],
            12,
            null,
        );

        return Inertia::render(
            'Home',
            [
                'trendEvents' => new EventsJsonResource(
                    $this->eventMeilisearchService
                        ->getPublishedEventSearch($trendParams)
                ),
                'trendCategories' => new CategoryWithCountJsonResource(
                    $this->categoryService->getTrendCategories()
                ),
                'trendTags' => new TagWithCountJsonResource(
                    $this->tagService->getTrendTag()
                ),
                'newEventsUrl' => route('event.search.index', [
                    't' => $newParams->text,
                    'q' => $newParams->queryParams,
                    'paginate' => $newParams->getDefaultPaginate(),
                    'o' => $newParams->order,
                ]),
                'newEvents' => new EventsJsonResource(
                    $this->eventMeilisearchService
                        ->getPublishedEventSearch($newParams)
                ),
                'ongoingEventsUrl' => route('event.search.index', [
                    't' => $ongoingParams->text,
                    'q' => $ongoingParams->queryParams,
                    'paginate' => $ongoingParams->getDefaultPaginate(),
                    'o' => $ongoingParams->order,
                ]),
                'ongoingEvents' => new EventsJsonResource(
                    $this->eventMeilisearchService
                        ->getPublishedEventSearch($ongoingParams)
                ),
                'recentEventsUrl' => route('event.search.index', [
                    't' => $recentParams->text,
                    'q' => $recentParams->queryParams,
                    'paginate' => $recentParams->getDefaultPaginate(),
                    'o' => $recentParams->order,
                ]),
                'recentEvents' => new EventsJsonResource(
                    $this->eventMeilisearchService
                        ->getPublishedEventSearch($recentParams)
                ),
            ]
        );
    }
}
