<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Inertia\Inertia;
use App\Models\ScreenName;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
            [['include' => 'and', 'type' => 'organizer', 'value' => $screenNameable->name]],
            12,
            'new',
        );
        $EventSearchParams = new SearchParams(
            '',
            [['include' => 'and', 'type' => 'performer', 'value' => $screenNameable->name]],
            12,
            'new',
        );

        Log::info('screenNameable: ' . $screenNameable->screen_nameable_type);
        return Inertia::render('Profile', [
            'profile' => match ($screenNameable->screen_nameable_type) {
                'App\Models\Team' => new TeamPublicProfileJsonResource($screenNameable->screen_nameable),
                'App\Models\User' => new UserPublicProfileJsonResource($screenNameable->screen_nameable),
                default => abort(404, 'Profile type not found'),
            },
            'events' => new EventsPaginatedJsonResource(
                $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
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
