<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Pickup;
use App\Enums\EventStatus;
use App\Services\TagService;
use App\Services\EventService;
use App\Services\CategoryService;
use App\Http\Resources\EventsJsonResource;
use App\Http\Resources\PickupsJsonResource;
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
        $ongoingParams = new SearchParams(
            '',
            [['include' => 'and', 'type' => 'status', 'value' => EventStatus::ONGOING->value]],
            12,
            null,
        );

        $upcomingParams = new SearchParams(
            '',
            [['include' => 'and', 'type' => 'status', 'value' => EventStatus::UPCOMING->value]],
            12,
            null,
        );

        $newParams = new SearchParams(
            '',
            [],
            12,
            'new',
        );

        $ongoingEvents = $this->eventMeilisearchService
            ->searchPublishedEvents($ongoingParams);
        $upcomingEvents = $this->eventMeilisearchService
            ->searchPublishedEvents($upcomingParams);
        $newEvents = $this->eventMeilisearchService
            ->searchPublishedEvents($newParams);

            $pickups = Pickup::with('pickupable')
                ->ofTypes([User::class, Team::class])
                ->paginate(10);

        return Inertia::render(
            'Home',
            [
                'pickups' => fn () => new PickupsJsonResource($pickups),
                'trendCategories' => fn () => new CategoryWithCountJsonResource($this->categoryService->getTrendCategories(10)),
                'trendTags' => fn () => new TagWithCountJsonResource($this->tagService->getTrendTag(10)),
                'ongoingEvents' => fn () => new EventsJsonResource($ongoingEvents),
                'ongoingEventsUrl' => fn () => route('event.search.index', [
                    't' => $ongoingParams->text,
                    'q' => $ongoingParams->queryParams,
                    'paginate' => $ongoingParams->getDefaultPaginate(),
                    'o' => $ongoingParams->order,
                ]),
                'upcomingEvents' => fn () => new EventsJsonResource($upcomingEvents),
                'upcomingEventsUrl' => fn () => route('event.search.index', [
                    't' => $upcomingParams->text,
                    'q' => $upcomingParams->queryParams,
                    'paginate' => $upcomingParams->getDefaultPaginate(),
                    'o' => $upcomingParams->order,
                ]),

                'newEvents' => fn () => new EventsJsonResource($newEvents),
                'newEventsUrl' => fn () => route('event.search.index', [
                    't' => $newParams->text,
                    'q' => $newParams->queryParams,
                    'paginate' => $newParams->getDefaultPaginate(),
                    'o' => $newParams->order,
                ]),
                'ongoingEventCount' => fn () => Event::ongoingPublished()->count(),
                'upcomingEventCount' => fn () => Event::upcomingPublished()->count(),
            ]
        );
    }
}
