<?php

namespace App\Http\Controllers\Profile;

use Inertia\Inertia;
use App\Models\ScreenName;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Http\Resources\TeamPublicProfileJsonResource;
use App\Http\Resources\UserPublicProfileJsonResource;
use App\Services\DynamicSearch\Meilisearch\SearchParams;
use App\Services\DynamicSearch\Meilisearch\Event\EventMeilisearchService;

class GetProfileController extends Controller
{
    public function __construct(
        private EventMeilisearchService $eventMeilisearchService
    ) {}

    /**
     * ユーザーのプロファイルを表示します。
     */
    public function __invoke($screen_name)
    {
        $screenNameable = ScreenName::findScreenNameable($screen_name);
        $EventSearchParams = new SearchParams(
            '',
            [
                ['include' => 'and', 'type' => 'organizer', 'value' => $screenNameable->screen_name],
                ['include' => 'or', 'type' => 'performer', 'value' => $screenNameable->screen_name],
            ],
            12,
            'new',
        );

        return Inertia::render('Profile/Index', [
            'isAuthUser' => Auth::check() && Auth::user()->id === $screenNameable->screenNameable->id,
            'profile' => match ($screenNameable->screen_nameable_type) {
                'App\Models\Team' => new TeamPublicProfileJsonResource($screenNameable->screenNameable->load('tags', 'links')),
                'App\Models\User' => new UserPublicProfileJsonResource($screenNameable->screenNameable->load('tags', 'links')),
                default => abort(404, 'Profile type not found'),
            },
            'events' => new EventsPaginatedJsonResource(
                $this->eventMeilisearchService->searchPublishedEvents($EventSearchParams)
            ),
            'url' => route('event.search.index', [
                't' => $EventSearchParams->text,
                'q' => $EventSearchParams->queryParams,
                'paginate' => $EventSearchParams->getDefaultPaginate(),
                'o' => $EventSearchParams->order,
            ]),
        ]);
    }
}
