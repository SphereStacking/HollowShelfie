<?php

namespace App\Http\Controllers\Profile;

use Inertia\Inertia;
use App\Enums\EventStatus;
use App\Models\ScreenName;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileGetRequeset;
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
    public function __invoke(ProfileGetRequeset $request, $screen_name)
    {

        $filter = $request->input('filter', []);
        $screenNameable = ScreenName::findScreenNameable($screen_name);

        $filterCount = count($filter);
        if (in_array($filterCount, [0, 2])) {
            $queryParams = [
                ['include' => 'and', 'type' => 'organizer', 'value' => $screenNameable->screen_name],
                ['include' => 'or', 'type' => 'performer', 'value' => $screenNameable->screen_name],
            ];
        } else {
            $queryParams = array_map(fn($filter) => [
                'include' => 'and',
                'type' => $filter,
                'value' => $screenNameable->screen_name
            ], $filter);
        }

        // 検索パラメータの設定
        $EventSearchParams = new SearchParams(
            '',
            $queryParams,
            24,
            'new'
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
        ])->with([
            'query' => $request->query()
        ]);
    }
}
