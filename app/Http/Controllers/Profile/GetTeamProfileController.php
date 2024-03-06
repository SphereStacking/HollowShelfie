<?php

namespace App\Http\Controllers\Profile;

use App\Models\Team;
use Inertia\Inertia;
use App\Services\TeamService;
use App\Services\UserService;
use App\Params\EventSearchParams;
use App\Http\Controllers\Controller;
use App\Services\EventMeilisearchService;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Http\Resources\TeamPublicProfileJsonResource;

class GetTeamProfileController extends Controller
{
    protected $userService;
    protected $teamService;
    protected $eventMeilisearchService;

    public function __construct(
        UserService $userService,
        TeamService $teamService,
        EventMeilisearchService  $eventMeilisearchService
    ) {
        $this->userService = $userService;
        $this->teamService = $teamService;
        $this->eventMeilisearchService = $eventMeilisearchService;
    }

    /**
     * チームのプロファイルを表示します。
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\View\View
     */
    public function __invoke(Team $team)
    {
        // Team モデルのルートモデルバインディングを使用してユーザーを取得
        // ユーザープロファイルのビューを返す
        $EventSearchParams = new EventSearchParams(
            '',
            [['include' => 'and', 'type' => 'user', 'value' => $team->name]],
            12,
            'new',
        );

        return Inertia::render('Team/Index', [
            'profile' => new TeamPublicProfileJsonResource(
                $this->teamService->preloadProfileData($team),
            ),
            'events' => new EventsPaginatedJsonResource(
                $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
            ),
            'url' => route('event.search.index', [
                't' => $EventSearchParams->text,
                'q' => $EventSearchParams->queryParams,
                'paginate' => $EventSearchParams->getDefaultPaginate(),
                'o' => $EventSearchParams->order,
            ])
        ]);
    }
}
