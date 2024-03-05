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
use App\Params\EventEloquentSearchParams;
use App\Services\EventEloquentSearchService;
use App\Http\Resources\EventsPaginatedJsonResource;

class GetManageEventController extends Controller
{
    private EventEloquentSearchService $eventEloquentSearchService;
    private TagService $tagService;

    public function __construct(EventEloquentSearchService $eventEloquentSearchService, TagService $tagService)
    {
        $this->eventEloquentSearchService = $eventEloquentSearchService;
        $this->tagService = $tagService;
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
            'categories' =>  fn () => Category::all(),
            'instanceTypes' => fn () => InstanceType::all()->pluck('name'),
            'statuses' =>  fn () => EventStatus::getPermittedStatusesForAdminSearch(),
            'trendTags' => fn () => $this->tagService->getTrendTagNames(),
        ]);
    }
}
