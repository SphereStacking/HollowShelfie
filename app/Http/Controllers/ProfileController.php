<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\TeamService;
use App\Services\UserService;
use App\Params\EventSearchParams;
use App\Services\EventMeilisearchService;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Http\Resources\UserPublicProfileJsonResource;
use App\Http\Resources\TeamPublicProfileJsonResource;
use App\Models\Team;

class ProfileController extends Controller
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

    //
    /**
     * ユーザーのプロファイルを表示します。
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function user(User $user)
    {
        // User モデルのルートモデルバインディングを使用してユーザーを取得
        // ユーザープロファイルのビューを返す
        $EventSearchParams = new EventSearchParams(
            '',
            [['include' => 'and', 'type' => 'user', 'value' => $user->name]],
            12,
            'new',
        );

        return Inertia::render('User/Index', [
            'profile' => new UserPublicProfileJsonResource(
                $this->userService->preloadProfileData($user),
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

    /**
     * チームのプロファイルを表示します。
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\View\View
     */
    public function team( Team $team)
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
