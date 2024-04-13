<?php

namespace App\Http\Controllers\Event;

use App\Enums\EventStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Models\Category;
use App\Models\InstanceType;
use App\Params\EventEloquentSearchParams;
use App\Services\EventEloquentSearchService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class GetManageEventController extends Controller
{
    public function __construct(
        private readonly EventEloquentSearchService $eventEloquentSearchService,
        private readonly TagService $tagService
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $user = Auth::user();

        $eventSearchParams = new EventEloquentSearchParams(
            $request->input('t', null),
            $request->input('q', null),
            $request->input('paginate', 12),
            $request->input('o', null),
        );
        $events = $this->eventEloquentSearchService->getEventSearchByUser($user, $eventSearchParams);

        return Inertia::render('Event/EventManage', [
            'events' => new EventsPaginatedJsonResource($events),
            'categories' => fn () => Category::all(),
            'instanceTypes' => fn () => InstanceType::query()->pluck('name'),
            'statuses' => fn () => EventStatus::ADMIN_SEARCH_STATUSES,
            'trendTags' => fn () => $this->tagService->getTrendTagNames(),
        ]);
    }
}
