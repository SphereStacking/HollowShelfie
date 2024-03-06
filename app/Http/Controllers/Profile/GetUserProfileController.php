<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Inertia\Inertia;
use App\Services\TeamService;
use App\Services\UserService;
use App\Params\EventSearchParams;
use App\Http\Controllers\Controller;
use App\Services\EventMeilisearchService;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Http\Resources\UserPublicProfileJsonResource;

class GetUserProfileController extends Controller
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
    public function __invoke(User $user)
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

}
